<?php


namespace Rackbeat\Traits;


trait ApiFiltering
{

	/** @var int[] */
	protected $wheres = [
		'limit' => 1000,
		'page'  => 1
	];

	/**
	 * @param array $filters
	 *
	 * @return string
	 */
	protected function parseFilters( $filters = [] ) {

		foreach ( $filters as $filter ) {
			$this->where( array_values( $filter ) );
		}


		$urlFilters = '';

		if ( count( $this->wheres ) > 0 ) {
			$i = 1;

			$urlFilters .= '?';

			foreach ( $this->wheres as $key => $filter ) {

				if ( ! is_array( $filter ) ) {
					$sign  = '=';
					$value = $filter;
				} else {
					[ $sign, $value ] = $filter;
				}

				$urlFilters .= $key . $sign . urlencode( $value );

				if ( count( $this->wheres ) > $i ) {

					$urlFilters .= '&';
				}

				$i++;
			}
		}

		return $urlFilters;
	}

	/**
	 * @param string      $key
	 * @param string|null $operator
	 * @param mixed       $value
	 *
	 * @return $this
	 */
	public function where( string $key, string $operator = null, $value = null ): self {
		if ( func_num_args() === 1 ) {
			$value = true;

			$operator = '=';
		}

		if ( func_num_args() === 2 ) {
			$value = $operator;

			$operator = '=';
		}

		$this->wheres[ $key ] = [ $operator, $value ];

		return $this;
	}

	/**
	 * @param int $limit
	 *
	 * @return $this
	 */
	public function limit( $limit = 1000 ): self {
		$this->wheres['limit'] = $limit;

		return $this;
	}

	/**
	 * @param int $page
	 *
	 * @return $this
	 */
	public function page( $page = 1 ): self {
		$this->wheres['page'] = $page;

		return $this;
	}
}