<?php namespace App\Helpers;

use Str;
use DB;

/**
 * Class Slug
 * @package Telecable\Helpers
 */
class Slug {

    /**
     * @var table
     */
    private $table;

    /**
     * @var $slug string
     */
    private $slug = null;

    /**
     * @var $field string
     */
    private $field = 'slug';

    /**
     * @var $slugId int
     */
    private $slugId;

    /**
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * @param $table string
     */
    public function setTable($table)
    {
        $this->table = $table;
    }

    /**
     * @param $field string
     */
    public function setField($field)
    {
        $this->field = $field;
    }

    /**
     * Genera el Slug
     *
     * @param string $title
     * @param string $table
     * @return string
     */
    public function generate($title, $table)
    {
        $this->table = $table;

        $slug = Str::slug($title);

        if( $this->exists($slug) )
        {
            $slug = $slug . '-' . $this->slugId;
        }

        $this->slug = $slug;

        return $slug;
    }

    /**
     * Determina si existe el slug
     *
     * @param strin $slug
     * @return bool
     */
    protected function exists($slug)
    {
        $this->slugId = DB::table($this->table)->where($this->field, 'like', $slug .'%')->count();

        return ($this->slugId) ? true : false;
    }
}