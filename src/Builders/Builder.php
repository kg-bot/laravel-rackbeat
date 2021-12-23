<?php


namespace Rackbeat\Builders;

use Psr\Http\Message\ResponseInterface;
use Rackbeat\Traits\ApiFiltering;
use Rackbeat\Utils\Model;
use Rackbeat\Utils\Request;
use Illuminate\Support\Str;


class Builder
{
	use ApiFiltering;

	protected $entity;
	/** @var Model */
	protected $model;
	protected $request;

	public function __construct( Request $request ) {
		$this->request = $request;
	}


	/**
	 * Get only first page of resources, you can also set query parameters, default limit is 1000
	 *
	 * @param array $filters
	 *
	 * @return mixed
	 * @throws \Rackbeat\Exceptions\RackbeatClientException
	 * @throws \Rackbeat\Exceptions\RackbeatRequestException
	 */
	public function get( $filters = [] ) {

		$urlFilters = $this->parseFilters( $filters );

		return $this->request->handleWithExceptions( function () use ( $urlFilters ) {

			$response     = $this->request->client->get( "{$this->entity}{$urlFilters}" );
			$fetchedItems = $this->getResponse( $response );

			return $this->populateModelsFromResponse( $fetchedItems->first() );
		} );
	}


	/**
	 * @param $response
	 *
	 * @return \Illuminate\Support\Collection|Model
	 */
	protected function populateModelsFromResponse( $response ) {
		$items = collect();
		if ( is_iterable( $response ) ) {
			foreach ( $response as $index => $item ) {
				/** @var Model $model */
				$modelClass = $this->getModelClass( $item );
				$model      = new $modelClass( $this->request, $item );

				$items->push( $model );
			}
		} else {
			$modelClass = $this->getModelClass( $response );

			return new $modelClass( $this->request, $response );
		}


		return $items;

	}

	/**
	 * It will iterate over all pages until it does not receive empty response, you can also set query parameters,
	 * default limit per page is 1000
	 *
	 * @param array $filters
	 *
	 * @return mixed
	 */
	public function all( $filters = [], $chunkSize = 100 ) {
		$entity = Str::plural($this->entity);
		$offset = 0;

		$response = function ( $filters, $offset, $entity ) use ($chunkSize){
			$filters['limit'] = $chunkSize;
			$filters['offset'] = $offset;

			$urlFilters = $this->parseFilters( $filters );

			return $this->request->handleWithExceptions( function () use ( $urlFilters, $entity ) {
				$response = $this->request->client->get( "{$this->entity}{$urlFilters}" );
				$responseData = json_decode( (string) $response->getBody() );
				$fetchedItems = collect($responseData->{$entity});
				$items = collect([]);
				$count = (isset($responseData->paging)) ? $responseData->paging->count : 0;

				foreach ($fetchedItems as $index => $item) {
					/** @var Model $model */
					$model = new $this->model($this->request, $item);
					$items->push($model);
				}
				return (object) [
					'items' => $items,
					'count' => $count,
				];
			} );
		};

		do {

			$resp = $response( $filters, $offset, $entity );

			$countResults = count($resp->items);
			if ( $countResults === 0 ) {
				break;
			}
			foreach ($resp->items as $result ) {
				yield $result;
			}

			unset( $resp );

			$offset += $chunkSize;

		} while ( $countResults === $chunkSize );
	}

	/**
	 * It will iterate over all pages until it does not receive empty response, you can also set query parameters,
	 * Return a Generator that you' handle first before quering the next offset
	 *
	 * @param int $chunkSize
	 *
	 * @return Generator
	 */
	public function allWithGenerator(int $chunkSize = 50)
	{
		$page = 1;
		$this->limit($chunkSize);

		$items = collect();

		$response = function ($page) {
			$this->page($page);
			$urlFilters = $this->parseFilters();

			return $this->request->handleWithExceptions(function () use ($urlFilters) {
				$response = $this->request->client->get("{$this->entity}{$urlFilters}");

				$responseData = json_decode((string) $response->getBody());
				$fetchedItems = $this->getResponse($response);
				$pages        = $responseData->pages;
				$items        = $this->populateModelsFromResponse($fetchedItems->first());

				return (object) [
					'items' => $items,
					'pages' => $pages,
				];
			});
		};

		do {
			$resp = $response($page);

			$countResults = count($resp->items);
			if ($countResults === 0) {
				break;
			}
			// make a generator of the results and return them
			// so the logic will handle them before the next iteration
			// in order to avoid memory leaks
			foreach ($resp->items as $result) {
				yield $result;
			}

			unset($resp);

			$page++;
		} while ($countResults === $chunkSize);
	}

	/**
	 * Find single resource by its id filed, it also accepts query parameters
	 *
	 * @param       $id
	 * @param array $filters
	 *
	 * @return mixed
	 * @throws \Rackbeat\Exceptions\RackbeatClientException
	 * @throws \Rackbeat\Exceptions\RackbeatRequestException
	 */
	public function find( $id, $filters = [] ) {
		unset( $this->wheres['limit'], $this->wheres['page'] );

		$urlFilters = $this->parseFilters( $filters );
		$id         = rawurlencode( rawurlencode( $id ) );

		return $this->request->handleWithExceptions( function () use ( $id, $urlFilters ) {
			$response     = $this->request->client->get( "{$this->entity}/{$id}{$urlFilters}" );
			$responseData = $this->getResponse( $response );

			return $this->populateModelsFromResponse( $responseData->first() );
		} );
	}

	/**
	 * Create new resource and return created model
	 *
	 * @param $data
	 *
	 * @return mixed
	 * @throws \Rackbeat\Exceptions\RackbeatClientException
	 * @throws \Rackbeat\Exceptions\RackbeatRequestException
	 */
	public function create( $data ) {
		return $this->request->handleWithExceptions( function () use ( $data ) {

			$response     = $this->request->client->post( $this->entity, [
				'json' => $data,
			] );
			$responseData = $this->getResponse( $response );

			return $this->populateModelsFromResponse( $responseData->first() );
		} );
	}

	public function getEntity() {
		return $this->entity;
	}

	public function setEntity( $new_entity ) {
		$this->entity = $new_entity;

		return $this->entity;
	}

	protected function getModelClass( $item ) {
		return $this->model;
	}

	protected function getResponse( ResponseInterface $response ) {
		return collect( json_decode( (string) $response->getBody() ) );
	}
}
