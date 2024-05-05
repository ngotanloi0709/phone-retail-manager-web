<?php
namespace app\services;
use app\models\Category;
use app\repositories\CategoryRepository;

Class CategoryService {

    private categoryRepository $CategoryRepository;

    public function __construct(CategoryRepository $categoryRepository) {
        $this->CategoryRepository = $categoryRepository;
    }

    public function getCategories() {
        return $this->CategoryRepository->findAll();
    }

    public function getCategoryById($id) {
        return $this->CategoryRepository->find($id);
    }

    public function createCategory(string $name): bool {
        if (empty($name)) {
            return false;
        }

        $category = new Category();
        $category->setName($name);

        return $this->CategoryRepository->save($category);
    }

    public function updateCategory(int $id, string $name): bool {
        if (empty($name)) {
            return false;
        }

        $category = $this->CategoryRepository->findByID($id);
        $category->setName($name);

        return $this->CategoryRepository->save($category);
    }

    public function deleteCategory($id): bool {
        $category = $this->CategoryRepository->findByID($id);
        $this->CategoryRepository->delete($category);
        return true;
    }
}

?>