<?php

namespace App\Repositories;

use App\Models\Tag;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class PostRepository
 * @package App\Repositories
 * @version March 5, 2018, 10:47 am UTC
 *
 * @method Post findWithoutFail($id, $columns = ['*'])
 * @method Post find($id, $columns = ['*'])
 * @method Post first($columns = ['*'])
*/
class TagRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'content'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Tag::class;
    }
}
