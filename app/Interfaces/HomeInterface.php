<?php
/**
   * Home Interface Class
   *
   * @package    Laravel
   * @author     Selvamanian <selvamanian@optisolbusiness.com>
   */
namespace App\Interfaces;

interface HomeInterface
{
	public function home();

    public function getSearch($post);
    
    public function getMore($post);
    
}