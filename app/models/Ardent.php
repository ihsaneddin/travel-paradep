<?php
use LaravelBook\Ardent\Ardent as Ardente;
use interfaces\NestedAttributesInterface;

class Ardent extends Ardente implements NestedAttributesInterface
{
	use NestedAttributes;

}