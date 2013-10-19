<?php
class Model_Post extends RedBean_SimpleModel
{
	public static function locate($key, $disallowNumeric = false)
	{
		if (is_numeric($key) and !$disallowNumeric)
		{
			$post = R::findOne('post', 'id = ?', [$key]);
			if (!$post)
				throw new SimpleException('Invalid post ID "' . $key . '"');
		}
		else
		{
			$post = R::findOne('post', 'name = ?', [$key]);
			if (!$post)
				throw new SimpleException('Invalid post name "' . $key . '"');
		}
		return $post;
	}

	public static function validateSafety($safety)
	{
		$safety = intval($safety);

		if (!in_array($safety, PostSafety::getAll()))
			throw new SimpleException('Invalid safety type "' . $safety . '"');

		return $safety;
	}

	public static function validateSource($source)
	{
		$source = trim($source);

		$maxLength = 100;
		if (strlen($source) > $maxLength)
			throw new SimpleException('Source must have at most ' . $maxLength . ' characters');

		return $source;
	}
}
