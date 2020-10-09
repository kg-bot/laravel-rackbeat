<?php


namespace Rackbeat\Utils;


use Illuminate\Support\Str;

class Model
{
	protected $entity;
	protected $primaryKey;
	protected $url_friendly_id;
	protected $modelClass = self::class;
	protected $fillable   = [];

	/**
	 * @var Request
	 */
	protected $request;

	public function __construct( Request $request, $data = [] ) {
		$this->request = $request;
		$data          = (array) $data;

		foreach ( $data as $key => $value ) {

			$customSetterMethod = 'set' . ucfirst( Str::camel( $key ) ) . 'Attribute';

			if ( !method_exists( $this, $customSetterMethod ) ) {

				$this->setAttribute( $key, $value );

			} else {

				$this->setAttribute( $key, $this->{$customSetterMethod}( $value ) );
			}
		}
	}

	protected function setAttribute( $attribute, $value ) {
		if ($attribute === $this->primaryKey) {

			$this->url_friendly_id = rawurlencode(rawurlencode($value));
		}

		$this->{$attribute} = $value;

	}

	public function __toString() {
		return json_encode( $this->toArray() );
	}

	public function toArray() {
		$data       = [];
		$class      = new \ReflectionObject( $this );
		$properties = $class->getProperties( \ReflectionProperty::IS_PUBLIC );

		foreach ( $properties as $property ) {

			$name          = $property->getName();
			$data[ $name ] = $this->{$name};
		}

		return $data;
	}

	public function delete() {
		return $this->request->handleWithExceptions( function () {

			$response = $this->request->client->delete("{$this->entity}/{$this->url_friendly_id}");


			return json_decode((string)$response->getBody());
		} );
	}

	public function update( $data = [] ) {

		return $this->request->handleWithExceptions( function () use ( $data ) {

			$response = $this->request->client->put("{$this->entity}/{$this->url_friendly_id}", [
				'json' => $data,
			]);


			$responseData = $this->getResponse( $response );

			return new $this->modelClass($this->request, $responseData->first());
		} );
	}

	public function getEntity() {
		return $this->entity;
	}

	public function setEntity( $new_entity ) {
		$this->entity = $new_entity;
	}

	protected function getResponse( $response ) {
		return collect( json_decode( (string) $response->getBody() ) );
	}
}