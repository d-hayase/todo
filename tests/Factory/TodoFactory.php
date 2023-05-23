<?php
declare(strict_types=1);

namespace App\Test\Factory;

use CakephpFixtureFactories\Factory\BaseFactory as CakephpBaseFactory;
use Faker\Generator;

/**
 * TodoFactory
 *
 * @method \App\Model\Entity\Todo getEntity()
 * @method \App\Model\Entity\Todo[] getEntities()
 * @method \App\Model\Entity\Todo|\App\Model\Entity\Todo[] persist()
 * @method static \App\Model\Entity\Todo get(mixed $primaryKey, array $options = [])
 */
class TodoFactory extends CakephpBaseFactory
{
    /**
     * Defines the Table Registry used to generate entities with
     *
     * @return string
     */
    protected function getRootTableRegistryName(): string
    {
        return 'Todo';
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

    public function withCategories($params = null): self
    {
        $param = $params['Categories']['params'];

        return $this->with('Categories', CategoryFactory::make($param));
    }
}
