<?php


namespace App\Repositories;


use App\Contract\CategoryContract;
use App\Models\Category;
use App\Traits\UploadAble;
use http\Exception\InvalidArgumentException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\UploadedFile;

class categoryRepository extends BaseRepository implements CategoryContract
{
    use UploadAble;

    public function __construct (Category $model)
    {
        parent::__construct($model);
        $this->model = $model;
    }

    /**
     * @param string         $order
     * @param string         $sort
     * @param array|string[] $columns
     * @return mixed
     */
    public function listCategories (string $order = 'id', string $sort = 'desc', array $columns = ['*'])
    {
        return $this->all($columns, $order, $sort);
//        return $this->all($columns, $order, $sort)->pluck('name', 'id');
////            ->with('children');
    }

    /**
     * @param int $id
     * @return mixed
     * @throws ModelNotFoundException
     */
    public function findCategoryById (int $id)
    {
        try {
            return $this->findOneOrFail($id);
        } catch (ModelNotFoundException $e) {

            throw new ModelNotFoundException($e);
        }
    }

    public function findBySlug ($slug)
    {
//        return Category::with('products')
//            ->where('slug', $slug)
//            ->where('menu', 1)
//            ->first();
         return Category::whereNotNull('parent_id')
             ->with('products')
             ->with('children')
             ->where('slug', $slug)
             ->where('menu', 1)
             ->first();
    }

    /**
     * @param array $params
     * @return Category
     */
    public function createCategory (array $params): Category
    {
        try {
            $collection = collect($params);

            $image = null;

            if ($collection->has('image') && ($params['image'] instanceof UploadedFile)) {
                $image = $this->uploadOne($params['image'], 'categories');
            }

            $featured = $collection->has('featured') ? 1 : 0;
            $menu = $collection->has('menu') ? 1 : 0;

            $merge = $collection->merge(compact('menu', 'image', 'featured'));

            $category = new Category($merge->all());
            $category->save();
            return $category;

        } catch (QueryException $exception) {
//            dd($exception);
            throw new InvalidArgumentException($exception->getMessage());
        }
    }

    public function updateCategory (array $params)
    {
        $category = $this->findCategoryById($params['id']);
        $collection = collect($params)->except('_token');
        $image = $category->image;
        if ($collection->has('image') && ($params['image'] instanceof UploadedFile)) {

            if ($category->image != null) {
                $this->deleteOne($category->image);
            }
            $image = $this->uploadOne($params['image'], 'categories');
        }

        $featured = $collection->has('featured') ? 1 : 0;
        $menu = $collection->has('menu') ? 1 : 0;
        $merge = $collection->merge(compact('menu', 'image', 'featured'));

        $category->update($merge->all());
        return $category;

    }

    public  function deleteCategory ($id)
    {
        $category = $this->findCategoryById($id);

        if ($category->image != null) {
            $this->deleteOne($category->image);
        }

        $category->delete();
        return $category;
    }

   public function treeLists ()
   {
       return Category::orderByRaw('-name ASC')
           ->get()
           ->nest()
           ->listsFlattened('name');
   }
}