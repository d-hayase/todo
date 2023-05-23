<?php
declare(strict_types=1);

namespace App\Test\Factory;

use CakephpFixtureFactories\Factory\BaseFactory as CakephpBaseFactory;
use Faker\Generator;

/**
 * BoardFactory
 *
 * @method \App\Model\Entity\Board getEntity()
 * @method \App\Model\Entity\Board[] getEntities()
 * @method \App\Model\Entity\Board|\App\Model\Entity\Board[] persist()
 * @method static \App\Model\Entity\Board get(mixed $primaryKey, array $options = [])
 */
class BoardFactory extends CakephpBaseFactory
{
    /**
     * Defines the Table Registry used to generate entities with
     *
     * @return string
     */
    protected function getRootTableRegistryName(): string
    {
        return 'Boards';
    }

    /**
     * Defines the factory's default values. This is useful for
     * not nullable fields. You may use methods of the present factory here too.
     *
     * @return void
     */
    protected function setDefaultTemplate(): void
    {
        $this->setDefaultData(function (Generator $faker) {
            return [
                // set the model's default values
                // For example:
                // 'name' => $faker->lastName
            ];
        });
    }

    public function withTodo($params = null, int $n = 1): self
    {
        // 接続法が指定されていれば、そちらを実行
        if (isset($params['Todo']['association'])) {
            $association = $params['Todo']['association'];

            return $this->$association($params);
        }

        return $this->with('Todo', TodoFactory::make($params['Todo']['params'], $n)->withCategories($params));
    }

    private function withHighPriorityTodo($params = null, $association = null): self
    {
        $param = $params['Todo']['params'];
        $param['category_id'] = 1; // 優先度高

        return $this->with('Todo', TodoFactory::make($param));
    }

    private function withMiddlePriorityTodo($params = null): self
    {
        $param = $params['Todo']['params'];
        $param['category_id'] = 2; // 優先度中

        return $this->with('Todo', TodoFactory::make($param));
    }

    private function withLowPriorityTodo($params = null): self
    {
        $param = $params['Todo']['params'];
        $param['category_id'] = 3; // 優先度低

        return $this->with('Todo', TodoFactory::make($param));
    }

}
