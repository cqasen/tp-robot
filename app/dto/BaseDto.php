<?php

namespace app\dto;

use app\base\NewInstanceTrait;
use think\contract\Arrayable;

class BaseDto implements \ArrayAccess, Arrayable
{
	use NewInstanceTrait;

	protected $items = [];

	public function __construct($items = [])
	{
		$this->items = $items;
		foreach ($items as $key => $value) {
			$this->{$key} = $value;
		}
	}

	public function __set($key, $value)
	{
		$this->{$key} = $value;
	}

	public function __get($name)
	{
		return $this->{$name};
	}

	public function __isset($name)
	{
		return isset($this->{$name}) || isset($this->items[$name]);
	}

	public function toArray(): array
	{
		return $this->items;
	}

	/**
	 * 支持按照访问数组方式访问对象属性
	 *
	 * @param mixed $offset 键
	 * @return mixed
	 */
	public function offsetGet($offset)
	{
		return $this->items[$offset];
	}

	/**
	 * 删除元素
	 *
	 * @param mixed $offset 键
	 */
	public function offsetUnset($offset)
	{
		unset($this->items[$offset]);
	}

	/**
	 * 设置元素的值
	 *
	 * @param mixed $offset 键
	 * @param mixed $value 值
	 */
	public function offsetSet($offset, $value)
	{
		$this->items[$offset] = $value;
	}

	/**
	 * 判断元素是否存在
	 *
	 * @param mixed $offset 键
	 * @return bool
	 */
	public function offsetExists($offset): bool
	{
		return isset($this->items[$offset]);
	}

}
