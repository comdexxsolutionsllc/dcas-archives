<?php
/**
* @package esiform
* @author Joshua Abbott, WiseGene Project (NKommunikation)
* @copyright (C) 2006 NKommunikation. All Rights Reserved.
* @desc EasyForm class
* @uses
* @example
* @files
*/

	/**
	 *
	 * Description:
	 * ------------
	 *	 
	 * This class is meant to create_, validate and process Web forms.
	 *
	 * When a valid form is submitted, the class can execute several types
	 * of built-in follow-up actions. 
	 *
	 * Currently it supports executing these types of follow-up actions:
	 *
	 * + Send an e-mail message to a given address based on a template that can
	 *   be processed using the submitted form values
	 * + Resubmit the form data to a given Web server using HTTP POST method
	 * + Execute a database query
	 *
	 * The class supports defining forms with many types of built-in validation
	 * rules including form field interdependency.
	 *
	 */
	
	class esiform
	{


		var $error_color 			= '#f00';
		var $error_message 		= '<p style="font-size:18px;color:#f00" class="esiform-error-message">Please correct / fill the red marked fields!</p>';
		var $error_occur			= false;
		var $default_pattern		= '{field}&nbsp;{name}&nbsp;';
		var $field_settings		= array();
		var $finished_fields		= array();
		var $follow_ups 			= true;
		var $is_error				= array();
		var $load_javascript		= array();
		var $method_type			= 'post';
		var $post_values			= array();
		var $required_sign 		= '<sup>*</sup>';
		var $required_sign_pos 	= 'front';
		var $return_type 			= 'print';
		var $return					= null;
		var $sexyness				= true;		/* necessary for nice animations ... */
		var $socket_returns		= array();
		var $template				= null;
		var $valid_email_syntax = '^[_a-zA-Z0-9-]+(\.[_a-zA-Z0-9-]+)*@[a-zA-Z0-9-]+(\.[a-zA-Z0-9-]+)*\.(([0-9]{1,3})|([a-zA-Z]{2,6})|(aero|coop|info|museum|name))$';
		var $xhtml					= true;
		

		/**
		 *
		 * constructor
		 *
		 */
		function esiform($settings)
		{

			/* find relative path to esiform-libs */
			$class_path = str_replace("\\","/",dirname(__FILE__)).'/';
			$script_path = str_replace("\\","/",dirname($_SERVER["SCRIPT_FILENAME"]));
			list($null,$settings["config"]["lib-path"]) = preg_split('#'.$_SERVER["DOCUMENT_ROOT"].'#',$class_path);
	
			$this->field_settings =& $settings["fields"];
			
			/* config init */
			if($settings["config"]["error-message"]) $this->error_message = $settings["config"]["error-message"];
			if($settings["config"]["error-color"]) $this->error_color = $settings["config"]["error-color"];
			if($settings["config"]["follow-ups"]) $this->follow_ups = $settings["config"]["follow-ups"];
			if($settings["config"]["method-type"]) $this->method_type = $settings["config"]["method-type"];
			if($settings["config"]["required-sign"]) $this->required_sign = $settings["config"]["required-sign"];
			if($settings["config"]["required-sign-pos"]) $this->required_sign_pos = $settings["config"]["required-sign-pos"];
			if($settings["config"]["return-type"]) $this->return_type = $settings["config"]["return-type"];
			if(isset($settings["config"]["sexyness"]) && !$settings["config"]["sexyness"]) $this->sexyness = false;
			if(!$settings["config"]["xhtml"]) $this->xhtml = false;

			/* start a session */
			session_start();
			
			/* copy the correct post values */
			if($this->method_type == 'post') $this->post_values = $_POST; else $this->post_values = $_GET;
				
			/* get template */
			if(is_file($settings["template"])) $this->template = join("",file($settings["template"]));
			else $this->template = $settings["template"];
			
			/* create_ fields */
			$this->create_FormFields($settings["fields"]);
			
			/* call follow-ups if validation is true */
			if($this->post_values["esiform-post-marker"] && !$this->error_occur && $this->follow_ups) $this->followUps_Start($settings["follow-ups"]);
			
			/* return template */
			$this->return_finishedTemplate($settings["config"]);
#			echo '<pre style="background-color:#ccc;padding:20px">'.htmlspecialchars($this->template).'</pre>';
			
		}


		/* ########################################################## */


		/**
		 *
		 *
		 *
		 */
		function create_FormFields($fields_array)
		{
			
			foreach($fields_array as $fid => $fsettings)
			{
				
				$label 			= null;
				$describ 		= $fsettings["describ"];
				$created_field	= null;

				/* set required sign */
				if($this->field_settings[$fid]["required"] && $this->field_settings[$fid]["label"] && (!isset($this->field_settings[$fid]["required-sign"]) || $this->field_settings[$fid]["required-sign"]))
				{
					if($this->required_sign_pos == 'front') $this->field_settings[$fid]["label"] = $this->required_sign.'&nbsp;'.$this->field_settings[$fid]["label"];
					else $this->field_settings[$fid]["label"] += '&nbsp;'.$this->required_sign;
				}
				
				/* activate fields */
				if($fsettings["activate"]) $this->validate_activateFields($fid);
	
				/* validate if necessary */
				$fsettings = $this->validate_formFields($fid);
					
				/* if box-hide == true */
				if($this->field_settings[$fid]["box-hide"]) $this->load_javascript[] = "if($('field-box-".$fid."')) $('field-box-".$fid."').style.display = 'none';";

				/* text, password, email, hidden fields */
				if($fsettings["type"] == 'text' || $fsettings["type"] == 'password' || $fsettings["type"] == 'email' || $fsettings["type"] == 'hidden') list($label,$created_field) = $this->create_TextFields($fid);
				
				/* text fields */
				if($fsettings["type"] == 'textarea') list($label,$created_field) = $this->create_TextareaFields($fid);

				/* checkbox & radio fields */
				if($fsettings["type"] == 'checkbox' || $fsettings["type"] == 'radio') list($label,$created_field) = $this->create_CheckboxRadioFields($fid);

				/* drop down fields */
				if($fsettings["type"] == 'select') list($label,$created_field) = $this->create_DropDownFields($fid);

				/* save finished fields */
				$this->finished_fields[$fid] = array
				(
					"label"			=> '<span class="esiform-label">'.$label.'</span>',
					"describ"		=> '<span class="esiform-describ">'.$describ.'</span>',
					"field"			=> $created_field,
					"error-text"	=> '<span style="color:'.$this->error_color.'" class="esiform-error-text">'.$this->field_settings[$fid]["error-text"].'</span>',
				);
					
			}
			
		}


		/* ########################################################## */


		/**
		 *
		 *
		 *
		 */
		function create_TextFields($field_id)
		{

			/* set pre-value */
			if(!$this->post_values["esiform-post-marker"] && $this->field_settings[$field_id]["value"]) $this->post_values[$field_id] = $this->field_settings[$field_id]["value"];

			$label = '<label for="'.$field_id.'">'.$this->field_settings[$field_id]["label"].'</label>';
			$created_field = '<input type="'.$this->field_settings[$field_id]["type"].'" id="'.$field_id.'" name="'.$field_id.'" value="'.$this->post_values[$field_id].'"'.$this->create_FieldAttributes($field_id).$this->create_FieldStyles($field_id).$this->create_FieldEvents($field_id).' />';

			return array($label,$created_field);
			
		}


		/* ########################################################## */


		/**
		 *
		 *
		 *
		 */
		function create_TextareaFields($field_id)
		{

			/* set pre-value */
			if(!$this->post_values["esiform-post-marker"] && $this->field_settings[$field_id]["value"]) $this->post_values[$field_id] = $this->field_settings[$field_id]["value"];

			$label = '<label for="'.$field_id.'">'.$this->field_settings[$field_id]["label"].'</label>';
			$created_field = '<textarea id="'.$field_id.'" name="'.$field_id.'"'.$this->create_FieldAttributes($field_id).$this->create_FieldStyles($field_id).$this->create_FieldEvents($field_id).'>'.$this->post_values[$field_id].'</textarea>';

			return array($label,$created_field);
			
		}


		/* ########################################################## */


		/**
		 *
		 *
		 *
		 */
		function create_CheckboxRadioFields($field_id)
		{

			$label = $this->field_settings[$field_id]["label"];

			$options = null;
			foreach($this->field_settings[$field_id]["options"]["values"] as $ok => $ov)
			{
				if(!$this->field_settings[$field_id]["options"]["keys"]) $ok = $ov;
				
				/* set array brackets for checkbox-fields */
				if($this->field_settings[$field_id]["type"] == 'checkbox') $set_multiple = '['.$ok.']'; else $set_multiple = null;

				/* set selection */
				if( 
					( !$this->post_values["esiform-post-marker"] && $this->field_settings[$field_id]["options"]["select"] && in_array($ok,$this->field_settings[$field_id]["options"]["select"]) ) || 
					(
						$this->post_values["esiform-post-marker"] &&	$this->post_values[$field_id] &&
						(
							(is_array($this->post_values[$field_id]) && in_array($ok,$this->post_values[$field_id])) ||
							(!is_array($this->post_values[$field_id]) && $ok == $this->post_values[$field_id])
						)
					)
				) $set_selected = ' checked'; else $set_selected = null;

				/* if there is no field-label defined, mark the option-values in the given error-color */
				if(!$this->field_settings[$field_id]["label"] && $this->is_error[$field_id]) $ov = '<span style="color:'.$this->error_color.'">'.$ov.'</span>';

				/* if there is no pattern, take the default one */
				if(!$this->field_settings[$field_id]["options"]["pattern"]) $this->field_settings[$field_id]["options"]["pattern"] = $this->default_pattern;
				$options[] = str_replace('{name}','<label for="'.$this->field_settings[$field_id]["type"].'-field-'.$field_id.'-'.$ok.'">'.$ov.'</label>',str_replace("{field}",'<input type="'.$this->field_settings[$field_id]["type"].'" id="'.$this->field_settings[$field_id]["type"].'-field-'.$field_id.'-'.$ok.'" name="'.$field_id.$set_multiple.'" value="'.$ok.'"'.$this->create_FieldAttributes($field_id).$this->create_FieldStyles($field_id).$this->create_FieldEvents($field_id,$ok).$set_selected.' />',$this->field_settings[$field_id]["options"]["pattern"]));
			}

			$created_field = join("",$options);

			return array($label,$created_field);
			
		}


		/* ########################################################## */


		/**
		 *
		 *
		 *
		 */
		function create_DropDownFields($field_id)
		{

			$label = '<label for="'.$field_id.'">'.$this->field_settings[$field_id]["label"].'</label>';

			$options = null;
			foreach($this->field_settings[$field_id]["options"]["values"] as $ok => $ov)
			{
				if(!$this->field_settings[$field_id]["options"]["keys"]) $ok = $ov;
				
				/* set selection */
				if( 
					( !$this->post_values["esiform-post-marker"] && $this->field_settings[$field_id]["options"]["select"] && in_array($ok,$this->field_settings[$field_id]["options"]["select"]) ) || 
					(
						$this->post_values["esiform-post-marker"] &&	$this->post_values[$field_id] &&
						(
							(is_array($this->post_values[$field_id]) && in_array($ok,$this->post_values[$field_id])) ||
							(!is_array($this->post_values[$field_id]) && $ok == $this->post_values[$field_id])
						)
					)
				) $set_selected = ' selected'; else $set_selected = null;
				
				$options[] = '<option value="'.$ok.'"'.$set_selected.'>'.$ov.'</option>';
			}

			/* if multiple drop down */
			if($this->field_settings[$field_id]["attributes"]["multiple"]) $set_multiple = '[]'; else $set_multiple = null;

			/* finish field */
			$created_field = '<select name="'.$field_id.$set_multiple.'" id="'.$field_id.'"'.$this->create_FieldAttributes($field_id).$this->create_FieldStyles($field_id).$this->create_FieldEvents($field_id).'>'.join("",$options).'</select>';

			return array($label,$created_field);
			
		}


		/* ########################################################## */


		/**
		 *
		 *
		 *
		 */
		function create_FieldStyles($field_id)
		{

			$style_string = array();
			if($this->field_settings[$field_id]["styles"])
			{
				foreach($this->field_settings[$field_id]["styles"] as $sk => $sv)
				{
					$style_string[] = $sk.':'.$sv;
				}
				
				return ' style="'.join(";",$style_string).'"';
			}
			
		}


		/* ########################################################## */


		/**
		 *
		 *
		 *
		 */
		function create_FieldAttributes($field_id)
		{

			$attribute_string = array();
			if($this->field_settings[$field_id]["attributes"])
			{
				foreach($this->field_settings[$field_id]["attributes"] as $ak => $av)
				{
					/* single attributes - such as "checked" ... */
					if(is_bool($av) && $av) $string = $ak;
					
					/* key, value attributes */
					else $string = $ak.'="'.$av.'"';
					
					$attribute_string[] = $string;
				}
				
				return ' '.join(" ",$attribute_string);
			}
			
		}


		/* ########################################################## */


		/**
		 *
		 *
		 *
		 */
		function create_FieldEvents($field_id,$field_key = null)
		{

			$event_string = array();
			if($this->field_settings[$field_id]["events"])
			{
				foreach($this->field_settings[$field_id]["events"] as $ek => $ev)
				{
					foreach($ev as $event => $show_after_post)
					{
						/* when there is no bool defined, pass the event over ... */
						if(!is_bool($show_after_post)) $event = $show_after_post;
						
						$event_call = $this->replace_eventPlaceHolders($field_id,$event,$field_key);
						$line_events[] = $event_call;

						if($show_after_post)
						{
							if($this->field_settings[$field_id]["type"] == 'checkbox' && ( (is_array($this->post_values[$field_id]) && in_array($field_key,$this->post_values[$field_id])) || (is_array($this->field_settings[$field_id]["options"]["select"]) && in_array($field_key,$this->field_settings[$field_id]["options"]["select"])) )) $this->load_javascript[] = $event_call;
							elseif($this->field_settings[$field_id]["type"] != 'checkbox' && ($this->post_values[$field_id] || (is_array($this->field_settings[$field_id]["options"]["select"]) && in_array($field_key,$this->field_settings[$field_id]["options"]["select"])) )) $this->load_javascript[] = $event_call;
						}
					}

					$event_string[] = $ek.'="'.join("",$line_events).'"';
				}
				
				return ' '.join("",$event_string);
			}
			
		}


		/* ########################################################## */


		/**
		 *
		 *
		 *
		 */
		function replace_eventPlaceHolders($field_id,$event_string,$field_key = null)
		{
			$new_event_string = array();
			if($this->field_settings[$field_id]["type"] == 'checkbox')
			{
				$event_string = str_replace("{option-id}",$field_key,$event_string);
				$event_string = str_replace("this.","$('checkbox-field-".$field_id."-".$field_key."').",$event_string);
			}
			else $event_string = str_replace("this.","$('".$field_id."').",$event_string);
			
			return $event_string;
		}
		
		
		/* ########################################################## */


		/**
		 *
		 *
		 *
		 */
		function validate_activateFields($field_id)
		{

			/* set the selected values */
			if(!$this->post_values[$field_id] && is_array($this->field_settings[$field_id]["options"]["select"])) $selected_values = $this->field_settings[$field_id]["options"]["select"];
			else $selected_values = $this->post_values[$field_id];
			
			/* if value based activation */
			if($this->field_settings[$field_id]["activate"]["if-value"])
			{
				foreach($this->field_settings[$field_id]["activate"]["if-value"] as $value => $fields_to_activate)
				{
					/* first set activation-fields = false */
					foreach($fields_to_activate as $fid)
					{
						$this->field_settings[$fid]["box-hide"] = true;
						if(!$this->post_values[$field_id]) $this->post_values[$fid] = null;
					}

					$do_activation = false;
					if(is_array($selected_values))
					{
						foreach($selected_values as $ak => $av)
						{
							if(!$this->field_settings[$field_id]["options"]["keys"]) $ak = $av;
							if(preg_match("#".$value."#i",$ak)) $do_activation = true;
						}
					}
					elseif(!is_array($selected_values) && preg_match("#".$value."#i",$selected_values)) $do_activation = true;
					
					if($do_activation)
					{
						/* activate given fields */
						foreach($fields_to_activate as $fid)
						{
							$this->field_settings[$fid]["required"] = true;
							$this->field_settings[$fid]["box-hide"] = false;
						}
					}

					/* add events to the parent field to show the passed fields instantly */
					if($this->field_settings[$field_id]["type"] == 'select') $event_type = 'onchange'; else $event_type = 'onclick';
					$this->field_settings[$field_id]["events"][$event_type]["validate_activateFields('".$field_id."','".$this->field_settings[$field_id]["type"]."','".$value."','".join(",",$fields_to_activate)."','".$this->sexyness."');"] = true;
				}
			}
			
			/* if the field is valid, activate the following fields */
			elseif(is_array($this->field_settings[$field_id]["activate"]))
			{
				/* first set activation-fields = false */
				foreach($this->field_settings[$field_id]["activate"] as $fid)
				{
					$this->field_settings[$fid]["box-hide"] = true;
					if(!$this->post_values[$field_id]) $this->post_values[$fid] = null;
				}

				/* activate given fields */
				if($selected_values)
				{
					foreach($this->field_settings[$field_id]["activate"] as $fid)
					{
						$this->field_settings[$fid]["required"] = true;
						$this->field_settings[$fid]["box-hide"] = false;
					}
				}

				/* add events to the parent field to show the passed fields instantly */
				if($this->field_settings[$field_id]["type"] == 'select') $event_type = 'onchange'; else $event_type = 'onclick';
				$this->field_settings[$field_id]["events"][$event_type]["validate_activateFields('".$field_id."','".$this->field_settings[$field_id]["type"]."','#for-all-values#','".join(",",$this->field_settings[$field_id]["activate"])."','".$this->sexyness."');"] = true;

			}

		}
		

		/* ########################################################## */


		/**
		 *
		 *
		 *
		 */
		function validate_formFields($field_id)
		{
			
			$found_error = false;
			
			/* was there already a post? */
			if($this->post_values["esiform-post-marker"])
			{

				/* replace regex-match if necessary */
				if($this->field_settings[$field_id]["valid"]["replace"])
				{
					$this->post_values[$field_id] = preg_replace("#".$this->field_settings[$field_id]["valid"]["replace"]."#smi","",$this->post_values[$field_id]);
				}
			
				/* required-valid-options */
				if($this->field_settings[$field_id]["required"])
				{

					/* field has to be filled */
					if(!$this->post_values[$field_id]) $found_error = true;
					
					/* if email-type, check if the syntax is correct */
					if($this->field_settings[$field_id]["type"] == 'email' && !preg_match("#".$this->valid_email_syntax."#smi",$this->post_values[$field_id])) $found_error = true;

					/* field has to be equal to the values of the passed field-array */
					if($this->field_settings[$field_id]["valid"]["equal-to"] && is_array($this->field_settings[$field_id]["valid"]["equal-to"]))
					{
						foreach($this->field_settings[$field_id]["valid"]["equal-to"] as $equal_to_field_ids)
						{
							if($this->post_values[$equal_to_field_ids] != $this->post_values[$field_id]) $found_error = true;
						}
					}
					
					/* field has to have a minium of chosen options */
					if($this->field_settings[$field_id]["valid"]["choose-min"] && is_array($this->post_values[$field_id]) && count($this->post_values[$field_id]) < $this->field_settings[$field_id]["valid"]["choose-min"]) $found_error = true;

					/* field has to have a maximum of chosen options */
					if($this->field_settings[$field_id]["valid"]["choose-max"] && is_array($this->post_values[$field_id]) && count($this->post_values[$field_id]) > $this->field_settings[$field_id]["valid"]["choose-max"]) $found_error = true;

					/* field has to match the given string */
					if($this->field_settings[$field_id]["valid"]["match"] && !preg_match("#".$this->field_settings[$field_id]["valid"]["match"]."#smi",$this->post_values[$field_id])) $found_error = true;

				}

				/* if error, mark field label in error-color */
				if($found_error)
				{
					$this->error_occur = true;
					$this->is_error[$field_id] = true;
					if($this->field_settings[$field_id]["label"]) $this->field_settings[$field_id]["label"] = '<span style="color:'.$this->error_color.'">'.$this->field_settings[$field_id]["label"].'</span>';
				}
				else $this->is_error[$field_id] = false;

			}
			
			return $this->field_settings[$field_id];
			
		}
		
		
		/* ########################################################## */


		/**
		 *
		 *
		 *
		 */
		function return_finishedTemplate($config)
		{
			
			foreach($this->finished_fields as $fid => $fsettings)
			{
				if(!$this->is_error[$fid]) $fsettings["error-text"] = null;
				$this->template = str_replace("{".$fid.":label}",$fsettings["label"],$this->template);
				$this->template = str_replace("{".$fid.":describ}",$fsettings["describ"],$this->template);
				$this->template = str_replace("{".$fid.":error}",$fsettings["error-text"],$this->template);

				/* xhtml fittings */
				if(!$this->xhtml) $fsettings["field"] = str_replace(" />",">",$fsettings["field"]);
				$this->template = str_replace("{".$fid.":field}",$fsettings["field"],$this->template);
			}
			
			/* add prototype- & esiform-classes */
			$javascript_add_ons[] = '<script type="text/javascript" src="'.$config["lib-path"].'3rd-party/scriptaculous/prototype.js"></script>';
			$javascript_add_ons[] = '<script type="text/javascript" src="'.$config["lib-path"].'esiform.class.js"></script>';
			if($this->sexyness) $javascript_add_ons[] = '<script type="text/javascript" src="'.$config["lib-path"].'3rd-party/scriptaculous/scriptaculous.js"></script>';

			$this->template = preg_replace("#(<form.*?>\s)#smi","\\1\t".join("\r\n\t",$javascript_add_ons),$this->template);

			/* load javascript */
			if(count($this->load_javascript) > 0) $this->template = str_replace("</form>","\r\n\t".'<script type="text/javascript">'."\r\n\t\t".join("\r\n\t\t",$this->load_javascript)."\r\n\t".'</script>'."\r\n\r\n</form>",$this->template);

			/* add post marker */
			$this->template = str_replace("</form>","\t".'<input type="hidden" name="esiform-post-marker" value="1" />'."\r\n</form>",$this->template);
			
			/* show error message */
			if(!$this->error_occur) $this->error_message = null;
			$this->template = str_replace("{error-message}",'<a name="esiform-error"></a>'.$this->error_message,$this->template);

			/* return final template */
			if($this->return_type == 'print') echo $this->template; else $this->return = $this->template;

		}

		
		/* ########################################################## */


		/**
		 *
		 *
		 *
		 */
		function followUps_Start($follow_ups)
		{

			foreach($follow_ups["types"] as $fk => $fv)
			{
				/* if we have conditions -> check them, else give a true anyway */
				if($this->followUp_Conditions($fv["conditions"]))
				{
					/*
						delete, replace, add fields and
						generate user_data-array out of the post-vars
					*/
					$user_data = $this->followUp_CreateUserData_Array($fv);

					/* call follow-ups */
					if(substr($fk,0,4) == 'mail') $this->followUp_Mail($fv,$user_data);
					elseif(substr($fk,0,6) == 'socket') $this->followUp_Socket($fv,$user_data);
					elseif(substr($fk,0,5) == 'mysql') $this->followUp_Mysql($fv,$user_data,$fk);
					elseif(substr($fk,0,4) == 'file') $this->followUp_File($fv,$user_data);
				}
			}
			
			if($follow_ups["redirect"]) header("Location: ".$follow_ups["redirect"]);
			else echo "<h1 style=color:#0c0>follow-up finished!</h1>";

		}
		

		/* ########################################################## */


		/**
		 *
		 *
		 *
		 */
		function followUp_Conditions($conditions)
		{

			$return = false;
			
			if($conditions)
			{

				/* equal to ... */
				if($conditions["equal"])
				{
					foreach($conditions["equal"] as $ck => $cv)
					{
						if($this->post_values[$ck] == $cv) $return = true;
						else $return = false;
					}
				}

				/* not equal to ... */
				if($conditions["not-equal"])
				{
					foreach($conditions["not-equal"] as $ck => $cv)
					{
						if($this->post_values[$ck] != $cv) $return = true;
						else $return = false;
					}
				}

				/* +++++++++++++++++++++++++++ */
				
				/* match to ... */
				if($conditions["match"])
				{
					foreach($conditions["match"] as $ck => $cv)
					{
						if(preg_match("#".$cv."#smi",$this->post_values[$ck])) $return = true;
						else $return = false;
					}
				}

				/* not match to ... */
				if($conditions["not-match"])
				{
					foreach($conditions["not-match"] as $ck => $cv)
					{
						if(!preg_match("#".$cv."#smi",$this->post_values[$ck])) $return = true;
						else $return = false;
					}
				}

				/* +++++++++++++++++++++++++++ */

				/* in-array to ... */
				if($conditions["in-array"])
				{
					foreach($conditions["in-array"] as $ck => $cv)
					{
						if(in_array($cv,$this->post_values[$ck])) $return = true;
						else $return = false;
					}
				}

				/* not in-array to ... */
				if($conditions["not-in-array"])
				{
					foreach($conditions["not-in-array"] as $ck => $cv)
					{
						if(!in_array($cv,$this->post_values[$ck])) $return = true;
						else $return = false;
					}
				}

				/* return result */
				if($return) return true; else return false;
				
			}
			else return true;

		}


		/* ########################################################## */


		/**
		 *
		 *
		 *
		 */
		function followUp_CreateUserData_Array($data)
		{

			$user_data = array();
			unset($this->post_values["esiform-post-marker"]);

			/* copy post-values to $user_data-array */
			foreach($this->post_values as $k => $v)
			{
				/* replace vars */
				if($data["replace"])
				{
					/* replace values by ... */
					foreach($data["replace"] as $rk => $rv)
					{

						/* replace by value comparison */
						if($rk == 'if-value')
						{
							foreach($rv as $field_id => $condition_array)
							{
								if($field_id == $k)
								{
									foreach($condition_array as $find => $replace_to)
									{
										/* check if there is regex: match necessary */
										if(substr($find,0,6) == 'regex:')
										{
											$find = str_replace("regex:","",$find);
											$regex = true;
										}
										else $regex = false;
										
										/* check & replace */
										if(is_array($v) && $regex)
										{
											foreach($v as $mkey => $mval) if(preg_match("#".$find."#smi",$mval)) $v[$mkey] = $replace_to;
										}
										elseif(is_array($v) && !$regex && in_array($find,$v)) $v[$find] = $replace_to;
										elseif($regex && preg_match("#".$find."#smi",$v)) $v = $replace_to;
										elseif(!$regex && $v == $find) $v = $replace_to;
										
									}
								}
							}
						}
						
						/* just replace by key */
						elseif($k == $rk)
						{
							if(is_array($rv))
							{
								foreach($rv as $rk2 => $rv2)
								{
									if(is_array($v) && in_array($rk2,$v)) $v[$rk2] = $rv2;
								}
							}
							else $v = $rv;
						}

					}
				}
				
				/* if there is no delete-array, just create an empty array */		
				if(!$data["delete"]) $data["delete"] = array();

				/* if field is in delete-array, leave it out of the $user_data-array */
				if(!in_array($k,$data["delete"])) $user_data[$k] = $v;
			}
			
			/* add vars if necessary */
			if($data["add"])
			{
				foreach($data["add"] as $k => $v)
				{
					
					if(is_array($user_data[$k]))
					{
						if(is_array($v)) foreach($v as $add_value) $user_data[$k][$add_value] = $add_value;
						else $user_data[$k][$v] = $v;
					}
					else $user_data[$k] = $v;
					
				}
			}

			return $user_data;

		}
		

		/* ########################################################## */


		/**
		 *
		 *
		 *
		 */
		function followUp_tagReplacements($user_data,$data_string,$join_array = null)
		{

			/* replace placeholders */
			foreach($user_data as $k => $v)
			{
				if(is_array($v))
				{
					if(!$join_array) $data_string = $this->followUp_tagReplacements($v,$data_string);
					else $v = join($join_array,$v);
				}
				
				$data_string = str_replace("{".$k."}",$v,$data_string);
				$data_string = str_replace("{".$k."-format}",$this->followUp_formatString($v),$data_string);
				$data_string = str_replace("{".$k."-id}",$k,$data_string);
			}
			
			return $data_string;

		}
		
		
		/* ########################################################## */


		/**
		 *
		 *
		 *
		 */
		function followUp_autoText($user_data,$spaces = null,$list_sign = null)
		{
	
			$auto_text = array();
			$cache_spaces = array();
			$default_tab = '  ';
						
			foreach($user_data as $uk => $uv)
			{
				
				if($uk != "esiform-post-marker")
				{
					if(is_array($uv)) $text = $spaces."{".$uk."-id}:\r\n".$this->followUp_autoText($uv,$spaces.'    ','=> ')."\r\n";
					else
					{
						$cache_spaces[$uk] = strlen($uk);
						if(!$list_sign) $text = $list_sign.'{'.$uk.'-id}:{cache-spaces-'.$uk.'}{'.$uk.'}';
						else $text = $list_sign.'{'.$uk.'}';
					}
					
					$auto_text[] = $spaces.$text;
				}
			}
			
			$finished_text = join("\r\n",$auto_text);
			
			/* tabin text */
			arsort($cache_spaces);
			foreach($cache_spaces as $uk => $uv)
			{
				if(!$most_chars)
				{
					$most_chars = $uv;
					$finished_text = str_replace('{cache-spaces-'.$uk.'}',$default_tab,$finished_text);
				}
				else $finished_text = str_replace('{cache-spaces-'.$uk.'}',$this->return_textSpaces($most_chars-$uv).$default_tab,$finished_text);
			}
			
			return $finished_text;
			
		}
		

		/* ########################################################## */


		/**
		 *
		 *
		 *
		 */
		function followUp_Mail_replaceSenderTags($user_data,$sender_array)
		{
			if(is_array($sender_array))
			{
				foreach($sender_array as $k => $v) $sender_array[$k] = $this->followUp_tagReplacements($user_data,$v);
				return $sender_array;
			}
		}
		
		/* ########################################################## */


		/**
		 *
		 *
		 *
		 */
		function followUp_Mail($data,$user_data)
		{
			
			/* load 3rd-party classes */
			require_once("3rd-party/phpmailer/class.phpmailer.php");
			require_once("3rd-party/send_mail.php");
			$mailer = new PHPMailer;

			/* get bodies */
			if($data["text"] && is_file($data["text"])) $data["text"] = join("",file($data["text"]));
			if($data["html"] && is_file($data["html"])) $data["html"] = join("",file($data["html"]));

			foreach(array("text" => $data["text"], "html" => $data["html"]) as $dk => $dv)
			{
				/* set auto-body */
				if($data[$dk] == ':auto' || $dk == 'text' && !$data[$dk]) $data[$dk] = $this->followUp_autoText($user_data);
				
				/* replace placeholders */
				$data[$dk] = $this->followUp_tagReplacements($user_data,$data[$dk]);
			}
			
			if(!$data["attachments"]) $data["attachments"] = null;
			if(!$data["embedded"]) $data["embedded"] = null;

			/* send e-mail */
			$send_users = Send_Email(
				array(
					"to"					=> $this->followUp_Mail_replaceSenderTags($user_data,$data["to"]),
					"cc"					=> $this->followUp_Mail_replaceSenderTags($user_data,$data["cc"]),
					"bcc"					=> $this->followUp_Mail_replaceSenderTags($user_data,$data["bcc"]),
					"from"				=> $this->followUp_tagReplacements($user_data,$data["from"]),
					"from-name"			=> $this->followUp_tagReplacements($user_data,$data["from-name"]),
					"subject"			=> $this->followUp_tagReplacements($user_data,$data["subject"]),
					"text"				=> $data["text"],
					"html"				=> $data["html"],
					"attachments"		=> $data["attachments"],
					"embedded"			=> $data["embedded"],
				),
				$mailer
			);

			/* fallback */
			if(!$send_users) $this->followUp_fallback($user_data);

		}


		/* ########################################################## */


		/**
		 *
		 *
		 *
		 */
		function followUp_Socket($data,$user_data)
		{

			/* format array-values */
			foreach($user_data as $k => $v)
			{
				if(is_array($v)) $user_data[$k] = join(",",$v);
			}
			
			/* send http-request */
			$return = $this->followUp_socketConnector(
				$data["host"],
				$data["port"],
				$data["method"],
				$data["path"],
				$user_data
			);

			/* handle returns */
			if($return)
			{

				/*
					Catch "Content-xreturn"-values
	
					A return has to be formated like this:
					Content-xreturn: <field-id:field-value><field-id:field-value> ...
				*/

				preg_match("#Content-xreturn:\s(.*)\s#",$return,$all_found_return_values);
				if($all_found_return_values[1])
				{
					preg_match_all("#<(.*?):(.*?)>#",$all_found_return_values[1],$single_return_values);
					foreach($single_return_values[1] as $id => $tag)
					{
						$this->post_values[$tag] = $single_return_values[2][$id];
					}
				}
				
			}
			
			/* fallback */
			if(!$return) $this->followUp_fallback($user_data);

		}


		/* ########################################################## */


		/**
		 *
		 *
		 *
		 */
		function followUp_Mysql($data,$user_data,$follow_up_name)
		{

			if($dbh = mysql_connect($data["host"],$data["user"],$data["password"]))
			{

				$query = "use ".$data["name"];
				mysql_query($query,$dbh);
	
				/* replace placeholders */
				$data["query"] = $this->followUp_tagReplacements($user_data,$data["query"],',');

				/* check for errors */
				$mysql_error = null;
				if(!mysql_error()) mysql_query($data["query"],$dbh);
				else $mysql_error = mysql_error()."\nQuery: &lt;".$data["query"]."&gt;";

				/* set the last inserted id */
				if(mysql_insert_id())
				{
					$this->post_values[$follow_up_name."-id"] = mysql_insert_id();
				}

				mysql_close($dbh);
	
				/* fallback */
				if($mysql_error) $this->followUp_fallback($user_data);
				
			}

		}


		/* ########################################################## */


		/**
		 *
		 *
		 *
		 */
		function followUp_File($data,$user_data,$file_error = 0)
		{

			$text = $this->followUp_autoText($user_data);
			$text = $this->followUp_tagReplacements($user_data,$text);
			
			$full_path = $data["path"];
			if(!$full_path) $full_path = '.';
			if(!preg_match("#/$#",$full_path)) $full_path .= "/";

			$full_path = str_replace("%session",session_id(),$full_path);
			$full_path = strftime($full_path);
			$full_path = $this->followUp_tagReplacements($user_data,$full_path);

			$file_name = $data["file-name"];
			$file_name = str_replace("%session",session_id(),$file_name);
			$file_name = strftime($file_name);
			$file_name = $this->followUp_tagReplacements($user_data,$file_name);
			
			/* check and create_ path if necessary */
			foreach(split("/",$full_path) as $path)
			{
				if($path)
				{
					$finished_path[] = $path;
					if(!file_exists(join("/",$finished_path))) mkdir(join("/",$finished_path));
				}
			}
			
			/* write file */
			if($fh = fopen($full_path.$file_name,"w"))
			{
				fwrite($fh,$text);
				fclose($fh);
			}
			
			/* fallback */
			else $this->followUp_fallback($user_data,$file_error);
						
		}


		/* ########################################################## */


		/**
		 *
		 *
		 *
		 */
		function followUp_fallback($user_data,$file_error = 0)
		{

			$data = array(
				"path" 		=> "fallback",
				"file-name"	=> "%y%m%d-%H%M-%session.txt",
			);
			
			/* fallback does only sense when there is no file error ... */
			if($file_error < 1) $this->followUp_File($data,$user_data,++$file_error);

		}
		

		/* ########################################################## */

		
		/**
		 *
		 * connect via socket
		 *
		 */
		function followUp_socketConnector($host, $port, $method, $path, $parameter)
		{
		
			/* connect */
			$fp = @fsockopen($host,$port,$errno,$errstr,5);
			
			if($fp)
			{
			
				/* format parameter */
				foreach($parameter as $k => $v) $finished_parameter[] = urlencode($k)."=".urlencode($v);
				$parameter = join("&",$finished_parameter);
				
				/* if ssl */
				if(substr($host,0,3) == "ssl") $path = 'https://'.$path;
				
				$method = strtoupper($method);
				
				if($method == "GET") $path .= '?'.$parameter;
				
				fputs($fp, $method." ".$path." HTTP/1.1\r\n");
				fputs($fp, "Host: $host\r\n");
			   fputs($fp, "User-Agent: esiform\r\n"); 
				fputs($fp, "Content-type: application/x-www-form-urlencoded\r\n");
				fputs($fp, "Content-length: ".strlen($parameter)."\r\n");
				fputs($fp, "Connection: close\r\n");
				fputs($fp, "\r\n");
	
				fputs($fp, "$parameter\r\n");
				
				/* cache return */
				while(!$end)
				{
					$line = fgets($fp, 4096);
					if(feof($fp) || preg_match("#^\s#",$line)) $end = 1;
					else $res .= $line;
				}
				
				fclose($fp);
				return $res;
			
			}
			else return false;
		
		}


		/* ########################################################## */
		
		
		/**
		 *
		 * format strings to upper- / lowercase
		 *
		 */
		function followUp_formatString($string)
		{
			
			$string = strtolower($string);
			if(!preg_match("#\@#",$string))
			{
	
				/* Bei Leerzeichen aufsplitten */
				$split_space = split(" ",$string);
				foreach($split_space as $Key => $Val) { $split_space[$Key] = ucfirst($Val); }
				$string = join(" ",$split_space);
	
				/* Bei Bindestrich aufsplitten */
				$split_line = split("-",$string);
				foreach($split_line as $Key => $Val) { $split_line[$Key] = ucfirst($Val); }
				$string = join("-",$split_line);
		
				/* Bei Punkten aufsplitten */
				$split_dot = split("\.",$string);
				foreach($split_dot as $Key => $Val) { $split_dot[$Key] = ucfirst($Val); }
				$string = join(". ",$split_dot);
		
				/* Bei Slash aufsplitten */
				$split_slash = split("/",$string);
				foreach($split_slash as $Key => $Val) { $split_slash[$Key] = ucfirst($Val); }
				$string = join("/",$split_slash);
		
				/* Bei BackSlash aufsplitten */
				$split_backslash = split("\\\\",$string);
				foreach($split_backslash as $Key => $Val) { $split_backslash[$Key] = ucfirst($Val); }
				$string = join("\\",$split_backslash);
		
				unset($split_space);
				unset($split_line);
				unset($split_slash);
				
			}
	
			/* Whitespaces am Beginn und Ende entfernen */
			$string = preg_replace("#(^ | $)#","",$string);
	
			/* Datumsangaben wieder richtigstellen */
			$string = preg_replace("#(\d+\.) (\d+\.) (\d+)#","\\1\\2\\3",$string);
			
			return $string;
		
		}


		/* ########################################################## */
		
		
		/**
		 *
		 *
		 *
		 */
		function replace_specialChars($string)
		{
		}


		/* ########################################################## */
		
		
		/**
		 *
		 *
		 *
		 */
		function return_textSpaces($count)
		{
			$spaces = null;
			for($i=0;$i<$count;$i++) { $spaces .= ' '; }
			return $spaces;
		}
		
	}

?>