<?php


namespace Rackbeat\Traits;


use Rackbeat\Utils\Model;

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
	protected function parseFilters( array $filters = [] ): string {

		foreach ( $filters as $filter ) {
			call_user_func_array( [ $this, 'where' ], array_values( $filter ) );
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
	 * Search for resources that only match your criteria, this method can be used in multiple ways
	 * Example 1:
	 * ->where('name', 'Test')
	 *
	 * Example 2:
	 * ->where('name', '=', 'Test')
	 *
	 * Example 3:
	 * ->where('is_active')
	 *
	 * If you use third example it will be sent as `is_active=true`
	 *
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
	 * How many resources we should load (max 1000, min 1)
	 *
	 * @param int $limit
	 *
	 * @return $this
	 */
	public function limit( int $limit = 1000 ): self {
		$this->where( 'limit', $limit );

		return $this;
	}

	/**
	 * @param int $page
	 *
	 * @return $this
	 */
	public function page( int $page = 1 ): self {
		$this->where( 'page', $page );

		return $this;
	}

	/**
	 * Set the return fields that you want
	 *
	 * @param array $fields
	 *
	 * @return $this
	 */
	public function fields( array $fields = [] ): self {
		$this->where( 'fields', implode( ',', $fields ) );

		return $this;
	}

	/**
	 * What should be expanded (loaded) in relation to requested resource (only field_values for now)
	 *
	 * @param string $expand
	 *
	 * @return $this
	 */
	public function expand( string $expand = 'field_values' ): self {
		$this->where( 'expand', $expand );

		return $this;
	}

	/**
	 * Search for exact field match, if you need to use starting_with match use ->field($id, $value)
	 *
	 * @param int $id
	 * @param     $value
	 *
	 * @return $this
	 */
	public function fieldEq( int $id, $value ): self {
		$this->where( 'field_eq[' . $id . ']', $value );

		return $this;
	}

	/**
	 * Search by field, this is not equal search so it can return more field, use ->fieldEq($id, $value) if you want to search for exact field
	 *
	 * @param int $id
	 * @param     $value
	 *
	 * @return $this
	 */
	public function field( int $id, $value ): self {
		$this->where( 'field[' . $id . ']', $value );

		return $this;
	}

	/**
	 * @param string $orderBy
	 *
	 * @return $this
	 */
	public function orderBy( string $orderBy ): self {
		$this->where( 'order_by', $orderBy );

		return $this;
	}

	/**
	 * @param string $direction
	 *
	 * @return $this
	 */
	public function orderDirection( string $direction = 'DESC' ): self {
		$this->where( 'order_direction', $direction );

		return $this;
	}

	/**
	 * @return $this
	 */
	public function orderDesc(): self {
		$this->orderDirection( 'DESC' );

		return $this;
	}

	/**
	 * @return $this
	 */
	public function orderAsc(): self {
		$this->orderDirection( 'ASC' );

		return $this;
	}

	/**
	 * Get first item ordered by desired field (or created_at by default)
	 *
	 * @param string $orderBy
	 *
	 * @return Model|null
	 */
	public function first( string $orderBy = 'created_at' ): ?Model {
		$this->limit( 1 );
		$this->orderBy( $orderBy );
		$this->orderAsc();

		return $this->get()->first();
	}

	/**
	 * Get last created item ordered by desired field (or created_at by default)
	 *
	 * @param string $orderBy
	 *
	 * @return Model|null
	 */
	public function last( string $orderBy = 'created_at' ): ?Model {
		$this->limit( 1 );
		$this->orderBy( $orderBy );
		$this->orderDesc();

		return $this->get()->first();
	}
}