<?php namespace Eubby\Controllers;

use View, Input, Redirect;

class IndexController extends BaseController 
{
	public function getIndex()
	{

		$this->notifier->setUser($this->acl->getUser());

		$keywords = (Input::get('keywords')) ? strtolower(Input::get('keywords')) : null;
		$searchError = false; //this allows us to display diff message in the view

		if( is_null($keywords))
		{
			//get all conversations in this forum
			$conversations 		= $this->conversation->orderby('updated_at', 'desc')->get();
		}
		else
		{
			//this tells the view that display a search error
			$searchError 		= true;
			
			//get all conversations in this forum
			$conversations 		= $this->conversation->where('title','LIKE', '%'.$keywords.'%')
												 ->orderby('updated_at', 'desc')
												 ->get();
		}

		//set some variables
		$final_data 		= array();
		$unread_count 		= 0;

		//update read/unread posts
		if ($this->acl->check()) 
		{
			//loop through all conversations
			for ($i=0; $i<$conversations->count(); $i++)
				{
					$channel = $this->channel->withTrashed()->where('id','=',$conversations[0]->channel_id)->first();
					
					//check if this conversation belongs to active channel, exclude if it belongs to deleted channel
					if ($channel->deleted_at == null)
					{
						//get user last visit date to get unread posts in this conversation
						$last_visit = $this->acl->lastVisit($conversations[$i]);
						$conversations[$i]->unread = $conversations[$i]->unreadPostsCount($last_visit);				
					}
					else
					{
						// if channel has been deleted, then unset this
						unset($conversations[$i]);
					}
				}
		}

		$this->layout->content  = View::make("theme::{$this->theme}.frontend.home.index")
									->with('conversations', $conversations)
									->with('searchError', $searchError);

		return $this->layout;
	}

}