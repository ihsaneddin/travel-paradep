<?php
use Codesleeve\Stapler\ORM\StaplerableInterface;
use Codesleeve\Stapler\ORM\EloquentTrait;

class Attachment extends Base implements StaplerableInterface{
	use EloquentTrait;

	protected $table = 'attachments';
	protected $fillable = ['name', 'description', 'image' ];
	public $errors;

	public function __construct(array $attributes =array())
	{
		$this->hasAttachedFile('image', [
			'styles' => [
				'medium' => '300x300',
				'carousel' => '250x250',
				'thumb' => '100x100'
			]
		]);
		parent::__construct($attributes);
	}

	public function rules()
	{
		$this->rules = [];
	}

	public function user()
	{
		return $this->belongsTo('User');
	}

	public function attachable()
    {
        return $this->morphTo();
    }
}