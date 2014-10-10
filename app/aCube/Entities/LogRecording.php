<?php namespace aCube\Entities;

class LogRecording extends \Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'log_recordings';

	/**
	 * @return $query
	 */
	public function scopePathFile($query, $id, $uniqueid) {
		return $query->where('id', $id)->where('uniqueid', $uniqueid)->lists('file');
	}

	/**
	 * @return $query
	 */
	public function scopeListsIds($query, $uniqueids)
	{
		if (is_array($uniqueids) && !empty($uniqueids)) {
			return $query->whereIn('uniqueid', $uniqueids);
		}
		return $query;
	}

}