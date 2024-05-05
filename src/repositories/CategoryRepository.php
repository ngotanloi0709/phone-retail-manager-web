<?php 

namespace app\repositories;
use app\models\Category;
use Doctrine\ORM\EntityRepository;

class CategoryRepository extends BaseRepository
{
    protected function getEntityClass(): string
    {
        return Category::class;
    }

    public function getNewCategory(): Category
    {
        return new Category();
    }

    public function getCategoryByName(string $name): ?Category
    {
        return $this->getEntityRepository()->findOneBy(['name' => $name]);
    } 
}

?>