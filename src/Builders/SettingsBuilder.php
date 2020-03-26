<?php
/**
 * Created by PhpStorm.
 * User: nts
 * Date: 31.3.18.
 * Time: 15.37
 */

namespace Rackbeat\Builders;


use Rackbeat\Exceptions\MethodNotImplemented;
use Rackbeat\Models\Settings;
use Rackbeat\Utils\Model;

class SettingsBuilder extends Builder
{
    protected $entity = 'settings';
    protected $model = Settings::class;

    public function create($data)
    {
        throw new MethodNotImplemented();
    }

    /**
     * This function does not accept any filters because this resource does not allow filtering yet
     *
     * @param array $filters
     * @return mixed
     * @throws \Rackbeat\Exceptions\RackbeatClientException
     * @throws \Rackbeat\Exceptions\RackbeatRequestException
     */
    public function get($filters = [])
    {
        return $this->request->handleWithExceptions(function () {

            $response = $this->request->client->get("{$this->entity}");


            $responseData = json_decode((string)$response->getBody());
            $fetchedItems = collect($responseData);
            $items = collect([]);

            foreach ($fetchedItems->first() as $index => $item) {


                /** @var Model $model */
                $model = new $this->model($this->request, $item);

                $items->push($model);


            }

            return $items;
        });
    }

    public function all($filters = [])
    {
        throw new MethodNotImplemented();
    }
}