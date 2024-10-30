<?php

/**
 * Register all actions and filters for the plugin
 *
 * @link       http://coderninja.in
 * @since      1.0.0
 *
 * @package    Cn_Gallery
 * @subpackage Cn_Gallery/includes
 */

/**
 * Register all actions and filters for the plugin.
 *
 * Maintain a list of all hooks that are registered throughout
 * the plugin, and register them with the WordPress API. Call the
 * run function to execute the list of actions and filters.
 *
 * @package    Cn_Gallery
 * @subpackage Cn_Gallery/includes
 * @author     Shivam <shivamsharma.shivam2@gmail.com>
 */
class Cn_Custom_Woo_Tabs_Query {

	// public function __construct() {
	// }

	public function iFetch($SQL)
	{
		global $wpdb;
		$record = array_shift($wpdb->get_results($SQL));
		$record=json_decode(json_encode($record),true);
		return $record;
	}

	public function iWhileFetch($sql){
		global $wpdb;
		$record = $wpdb->get_results($sql);
		$record=json_decode(json_encode($record),true);
		return $record;
	}

	public function iUpdateArray($table, $postData = array(),$conditions = array(),$html_spl='No')
	{

		foreach($postData as $k=>$value)
		{				
			if($html_spl=='Yes')
			{
				$value = htmlspecialchars($value);
			}
			if($value==NULL)
				$values .= "`$k` = NULL, ";
			else
				$values .= "`$k` = '$postData[$k]', ";
		}
		$values = substr($values, 0, strlen($values) - 2);
		foreach($conditions as $k => $v)
		{
			$v = htmlspecialchars($v);			
			$conds .= "$k = '$v'";
		}			
		$update = "UPDATE `$table` SET $values WHERE $conds";
		if($this->iQuery($update,$rs))
		{
			return true;
		}
		else
		{
			return false;
		}		
	}

	public function iQuery($SQL,&$rs)
	{
		if($this->iMainQuery($SQL,$rs))
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	public function iMainQuery($SQL,&$rs)
	{
		global $wpdb;		
		$rs=$wpdb->query($SQL);
		if($wpdb->last_error)
		{
			echo"<p style=\"color:#cc3f44;\"><strong>Start User Custom Error:<br/> </strong>".$wpdb->last_error."</p><p style=\"color:#72a230;\">".$wpdb->last_query."<br/><strong>End User Custom Error</strong></p>";
		}
		if($wpdb->last_error)
			return false;
		else
			return true;
	}

	public function iInsert($table, $postData = array(),$html_spl='No')
	{
		global $wpdb;
		$sql = "DESC $table";
		$getFields = array();		
		$fieldArr = $wpdb->get_results($sql);
		foreach($fieldArr as $field)
		{
			$field=json_decode(json_encode($field),true);
			$getFields[sizeof($getFields)] = $field['Field'];
		}
		$fields = "";
		$values = "";
		if (sizeof($getFields) > 0)
		{				
			foreach($getFields as $k)
			{
				if (isset($postData[$k]))
				{
					if($html_spl=='No')
					{
						$postData[$k] = $postData[$k];
					}
					else
					{
						$postData[$k] = htmlspecialchars($postData[$k]);
					}
					$fields .= "`$k`, ";
					$values .= "'$postData[$k]', ";
				}
			}			
			$fields = substr($fields, 0, strlen($fields) - 2);
			$values = substr($values, 0, strlen($values) - 2);
			$insert = "INSERT INTO $table ($fields) VALUES ($values)";
			if($this->iQuery($insert,$rs))
			{
				return true;
			}
			else
			{
				return false;
			}
		}
		else
		{
			return false;
		}
	}	

	public function showMessage($message,$type='info')
	{
		$msg='<div class="mrg"><div class="alert alert-'.$type.'"><button type="button" class="close" data-dismiss="alert">x</button>
		<center>'.__($message).'</center></div></div>';
		return $msg;
	}

}

