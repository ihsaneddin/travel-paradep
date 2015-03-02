<?php
use Codesleeve\Stapler\ORM\StaplerableInterface;
use Codesleeve\Stapler\ORM\EloquentTrait;

class Attachment extends Base implements StaplerableInterface{
	use EloquentTrait;

	protected $table = 'attachments';
	protected $fillable = ['name', 'description', 'image' ];
	protected $rules = ['name' => array( 'required', 'alpha_dash', 'max:200' )];
	protected $messages =array();

	public function __construct(array $attributes =array())
	{
		$this->hasAttachedFile('image', [
			'styles' => [
				'medium' => '300x300',
				'thumb' => '100x100'
			]
		]);
		parent::__construct($attributes);
	}

	public function user()
	{
		return $this->belongsTo('User');
	}
}