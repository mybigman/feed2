<?php
class Paginator extends Laravel\Paginator {

	public static function make($results, $total, $per_page)
	{
		$page = static::page($total, $per_page);
		// I don't want to return the last item if I go to page 10000
		if (!$page) {
			throw new PageNotFoundException('Page number invalid');
		}

		$last = ceil($total / $per_page);

		return new static($results, $page, $total, $per_page, $last);
	}

	public static function page($total, $per_page)
	{
		$page = Input::get('page', 1);

		// The page will be validated and adjusted if it is less than one or greater
		// than the last page. For example, if the current page is not an integer or
		// less than one, one will be returned. If the current page is greater than
		// the last page, the last page will be returned.
		if (is_numeric($page) and $page > $last = ceil($total / $per_page) and $page != 1)
		{
			return false;
		}

		return (static::valid($page)) ? $page : 1;
	}

	public function links($adjacent = 3)
	{
		if ($this->last <= 1) return '';

		// The hard-coded seven is to account for all of the constant elements in a
		// sliding range, such as the current page, the two ellipses, and the two
		// beginning and ending pages.
		//
		// If there are not enough pages to make the creation of a slider possible
		// based on the adjacent pages, we will simply display all of the pages.
		// Otherwise, we will create a "truncating" sliding window.
		if ($this->last < 7 + ($adjacent * 2))
		{
			$links = $this->range(1, $this->last);
		}
		else
		{
			$links = $this->slider($adjacent);
		}

		$content = $this->previous().' '.$links.' '.$this->next();

		return '<div class="button-group pagination">'.$content.'</div>';
	}

	protected function element($element, $page, $text, $disabled)
	{
		$class = "{$element}_page";

		if (is_null($text))
		{
			$text = Lang::line("pagination.{$element}")->get($this->language);
		}

		// Each consumer of this method provides a "disabled" Closure which can
		// be used to determine if the element should be a span element or an
		// actual link. For example, if the current page is the first page,
		// the "first" element should be a span instead of a link.
		if ($disabled($this->page, $this->last))
		{
			return HTML::span($text, array('class' => "{$class} disabled button"));
		}
		else
		{
			return $this->link($page, $text, $class);
		}
	}
	protected function range($start, $end)
	{
		$pages = array();

		// To generate the range of page links, we will iterate through each page
		// and, if the current page matches the page, we will generate a span,
		// otherwise we will generate a link for the page. The span elements
		// will be assigned the "current" CSS class for convenient styling.
		for ($page = $start; $page <= $end; $page++)
		{
			if ($this->page == $page)
			{
				$pages[] = HTML::span($page, array('class' => 'active button'));
			}
			else
			{
				$pages[] = $this->link($page, $page, null);
			}
		}

		return implode(' ', $pages);
	}
	protected function link($page, $text, $class)
	{
		$class .= ' button';

		if ($page != 1)
		{
			$query = '?page='.$page.$this->appendage($this->appends);
		} else {
			$query = '';
		}

		return HTML::link(URI::current().$query, $text, compact('class'), Request::secure());
	}
}