<?php
/**
* @package 
* @author Joshua Abbott, WiseGene Project (NKommunikation)
* @copyright (C) 2006 NKommunikation. All Rights Reserved.
* @desc 
* @uses
* @example
* @files
*/
/*
 *********************************************************************************************
 *
 *	
 *		Standard XML format Supported
 *		-----------------------------
 *
 *		 <Database>
 *
 *		   <Record>
 *			<Field1></Field1>
 *			<Field2></Field2>
 *			<Field3></Field3>
 *		   </Record>
 *	
 *		   <Record>
 *			<Field1></Field1>
 *			<Field2></Field2>
 *			<Field3></Field3>
 *		   </Record> 
 *
 *		   <Record>
 *			<Field1></Field1>
 *			<Field2></Field2>
 *			<Field3></Field3>
 *		   </Record> 
 *
 *		</Database>
 *
 *********************************************************************************************
 *
 *	Function List:
 *
 *		______________
 *		Main functions
 *		��������������
 *		function XML_DBarrayDump _
 *
 *			($XMLFile, _               -> ByVal: XML File Name
 *			 &$dbaseCaption, _         -> ByRef: Name Of Database
 *			 &$RecordCaption, _        -> ByRef: Name of records
 *			 &$RecordCount, _          -> ByRef: Number of Records
 *			 &$FieldCount, _           -> ByRef: Number of Fields
 *			 &$FieldCaptions)	   -> ByRef: Array of Field Names 
 *
 *			Return Value: 2D Array Containing XML Elements in such a format
 *				       -> XMLArray[RECORD_NUMBER][FIELD_NUMBER]
 *
 *			Main Use    : XML_DBarrayDump is the main XML parsing and reading
 *				      function. Properties like number of records, number of 
 *				      fields, data.. are produced/returned by this very function.
 *
 *		_________________________________________________________________________________	
 *
 *
 *		function XML_DBgetData _
 *
 *			($XMLFile, _                -> ByVal: XML File Name
 *			 $RecNum, _                 -> ByVal: Record Number
 *			 $FieldName)                -> ByVal: Array of field names
 *
 *			Return Value: Data in record of record number $RecNum
 *	
 *			Main Use    : Just to get a data from a field in a record.
 *
 *		_________________________________________________________________________________	
 *
 *		
 *		function XML_DBwriteFile
 *
 *			($XMLFile, _           -> ByVal: XML File Name
 *			 $RecordArray, _       -> ByVal: Array of the fields forming the records
 *			 $dbaseName, _         -> ByVal: Name of database
 *			 $RecordName, _        -> ByVal: Record Name
 *			 $FieldNameAry, _      -> ByVal: Array of field names
 *			 $RecNum, _            -> ByVal: Record Number
 *			 $FldNum)	       -> ByVal: Field Number
 *
 *			Return Value: NULL
 *	
 *			Main Use    : Obtain an Array of the data with the Record and dbase names
 *				      re-write the XML database.
 *
 *		_________________________________________________________________________________	
 *
 *
 *		function XML_DBaddRecord _
 *			
 *			($XMLFile, _		-> ByVal: XML File Name
 *			 $DataArray, _          -> ByVal: Array of data of a single record
 *			 $Mode, _               -> ByVal: Mode Of writing (Overwrite/Insert)
 *			 $PosToAdd)             -> ByVal: Where to add record (0 means EOF)
 *							  (equivalent to record number)
 *
 *			Return Value: NULL
 *	
 *			Main Use    : For this function there are 3 ways of adding a record
 *					
 *					1) Adding as per normal (to end of file)
 *					   Call with PosToAdd 0 and Mode could be ignored with 
 *					   a "" input.
 *
 *					2) Overwriting a record at a certain position
 *					   Call with PosToAdd at a selected position. And Mode
 *					   "OVERWRITE" this would replace record number PosToAdd
 *					   with the new record stored in DataArray
 *		
 *					3) Inserting a record at a certain position
 *					   Call with PosToADd at a selected position. And Mode
 *					   "INSERT" this would add a record making the record 
 *				           number of the new record PosToAdd. Preceeding records
 *					   will be pushed downwards.
 *
 *		_________________________________________________________________________________	
 *
 *
 *		function XML_DBdeleteRecord
 *
 *			($XMLFile, _              -> ByVal: XML File Name
 *			 $RecNum)		  -> ByVal: Record Number
 *
 *			Return Value: NULL
 *	
 *			Main Use    : Delete a record with record number RecNum
 *
 *		_________________________________________________________________________________	
 *
 *		_________________
 *		Support functions
 *		�����������������
 *
 *		function XML_STACK
 *
 *			($action, _		-> ByVal: PUSH or POP
 *			 $element, _		-> ByVal: Obj to push to stack
 *			 &$buffer)		-> ByRef: Buffer to pass the StackPointer to the
 *						          calling function
 *
 *			Return Value: NULL
 *	
 *			Main Use    : Handling Stack operations required in XML parsing.
 *
 *			NOTE        : Stack pointer will not exceed 3 as hierarchy is only at 
 *				      most 3 levels down.
 *
 *					Database
 *					   |
 *					   |-o Record
 *						 |
 *						 |-o Field
 *
 *				      Once it is 3 level down there will be a pop operation
 *				      when the field closes. therefore stack pointer will be 
 *				      a max at 3. (after reading open tag of field.)
 *		_________________________________________________________________________________	
 *
 *
 *********************************************************************************************
 */	

	
	function XML_STACK($action, $element, &$buffer) {
	
		global $ptrSTACK;
		global $STACK;
		
		switch ($action) {

			case "PUSH":

				$ptrSTACK += 1;
				$STACK[$ptrSTACK] = $element;
				break;

			case "POP":

				$ptrSTACK -= 1;
				break;
		}

		$buffer = $ptrSTACK;

		//For debugging purposes.
		//print $ptrSTACK . "$action<br>";
			
	}




	function XML_DBarrayDump($XMLFile, &$dbaseCaption, &$RecordCaption, &$RecordCount, &$FieldCount, &$FieldCaptions) {

		$fp        = file($XMLFile);
		$rec       = implode($fp, "");

		$openTags  = 0;
		$closeTags = 0;
		$Tagsets   = 0;
		$tmpFields = 0;
		$cntFields = 0;
		$ptrFields = 0;
		$cntRec    = 1;

		//$DataArray

		$inReccord = false;

		for ($i = 0; $i < strlen($rec); $i++) {

			$extChar = substr($rec, $i, 1);

			switch ($extChar) {
	
				case "<":

					$openTags += 1;
					$startTag  = $i;

					//Actually using the stack could return the number of fields much more easily but since done earlier in a sillier method just leave it...
					//ptrSTACK == 3 means that the file pointer is currently pointing to the < of the close tag of a field as in its open tag the push adds it to 3
					//once ptrSTACK reaches 1 then a record is finished therefore reset field pointer 

					//<field>data here</field>
					
					if ($buffer == 3) {
						$FieldArray[$ptrFields]             = $Tagcaption;
						$DataArray[$cntRec - 1][$ptrFields] = trim(substr($rec, $endTag + 1, $startTag - $endTag - 1));
						//print $endTag . "<br>";
						//print $startTag;
						//print $DataArray[$cntRec - 1][$ptrFields];
						$ptrFields += 1;
					}

					if ($buffer == 1) $ptrFields = 0;

					break;


				case ">":

					$closeTags += 1;
					$Tagsets   += 1;
					$endTag     = $i;


					/* The preceeding code...
					 *
 				  	 * Tagsets = 1,2... Meaning the tags are the database tag 
					 * and the record tag respectively
					 *
					 * This returns the caption of the dbase and rec in the 
					 * XML DB to the variables passed by ref.
					 *
				         */

					$start = $startTag + 1;
					$end   = $endTag - $startTag - 1;

					switch ($Tagsets) {
		
						case 0: break;
			
						case 1:

							$dbaseCaption = substr($rec, $start, $end);
							XML_STACK("PUSH", $dbaseCaption, $buffer);
							break;

						case 2: 

							$RecordCaption = substr($rec, $start, $end);
							XML_STACK("PUSH", $RecordCaption, $buffer);
							break;
						
						default: // > 2 

							$Tagcaption = substr($rec, $start, $end);

							$bool1      = (trim($Tagcaption) ==   trim($RecordCaption));
							$bool2      = (trim($Tagcaption) ==   trim($dbaseCaption));
							$bool3      = (trim($Tagcaption) == trim("/$RecordCaption"));
							$bool4      = (trim($Tagcaption) == trim("/$dbaseCaption"));
							$isCloseTag = (substr($Tagcaption, 0, 1) == "/");

							//This one for debugging purposes.
							//print "<b>$Tagcaption</b>";

							if (!($isCloseTag)) XML_STACK("PUSH", $Tagcaption, $buffer);
							if   ($isCloseTag)  XML_STACK("POP", "", $buffer);

							/*
							 * 1st if: if the current tag is not record or dbase open/close tags then can add to the temp number of fields
							 * 2nd if: if pointer reaches a new record and the actual number of fields is still unset (ie = 0) then have it set tp the temp number of fields.
							 * 3rd if: if current tag is a record tag then add to the record counter.
							 */

							if ((!(($bool1) || ($bool2) || ($bool3) || ($bool4))) && (!($isCloseTag))) $tmpFields += 1;
							if    (($bool1) && ($cntFields == 0)) $cntFields = $tmpFields;
							if     ($bool1) $cntRec += 1;

							break;
					}

					break;

			}

		}

		//for debugging purposes.
		//print $tmpFields;
		//print $DataArray[3][2];

		//print $FieldArray[0];  
		//print $FieldArray[1];  
		//print $FieldArray[2];  
		//print $FieldArray[3];  
		//print "<br><br>";


		//Return the values

		$RecordCount   = $cntRec;
		$FieldCount    = $cntFields;
		$FieldCaptions = $FieldArray;

		return $DataArray;

	}





	function XML_DBgetData($XMLFile, $RecNum, $FieldName) {

		//for this records start from 1 not 0

		$fieldexists = false;
		$XMLArray    = XML_DBarrayDump($XMLFile, $DB, $REC, $cntREC, $cntFLD, $FLD);
		$RecNum     -= 1;
		
		for ($i = 0; $i < $cntFLD; $i++) {
			if (trim($FieldName) == trim($FLD[$i])) {
				$ptr         = $i;
				$fieldexists = true;
			}
		}

		
		//field must be there
		//record number must not exceed
		//record number must not be lesser than 1.

		if (!($fieldexists))   return "";
		if ($RecNum > $cntREC) return "";
		if ($RecNum <= -1)     return "";

		return $XMLArray[$RecNum][$ptr];

	}





	function XML_DBwriteFile($XMLFile, $RecordArray, $dbaseName, $RecordName, $FieldNameAry, $RecNum, $FldNum) {
		 
		/* 
		 * Write the database back to the XML File with the updated array passed from
		 * the XML_DBaddRecord Function.
	         *
		 */


		$XMLString = "<$dbaseName>" . chr(13) . chr(10) . chr(13) . chr(10);

		
		//loop to write the records and the fields.

		for ($rec = 0; $rec < $RecNum; $rec++) {

			$XMLString .= "  <$RecordName>" . chr(13) . chr(10);

			for ($fld = 0; $fld < $FldNum; $fld++) {
				$XMLString .= "    <$FieldNameAry[$fld]>" . $RecordArray[$rec][$fld] . "</$FieldNameAry[$fld]>" . chr(13) . chr(10);
			}

			$XMLString .= "  </$RecordName>" . chr(13) . chr(10) . chr(13) . chr(10);

		}

		$XMLString .= "</$dbaseName>";

		$fp = fopen($XMLFile, "w");
		fwrite($fp, $XMLString);
		fclose($fp);
		
	}





	function XML_DBaddRecord($XMLFile, $DataArray, $Mode, $PosToAdd) {

		/*
		 * PosToAdd: 0     -> default value and this will have the record added to the eof
		 *         : [NUM] -> indicates the record number of this new record after add thus determining its final location
		 *
		 */	

	
		$XMLArray    = XML_DBarrayDump($XMLFile, $DB, $REC, $cntREC, $cntFLD, $FLD);
		

		if ($PosToAdd == 0) {  //Meaning add to the end of the file.

			//End of file therefore just require 1 more element to the array.

			for ($i = 0; $i < $cntFLD; $i++) {
				$XMLArray[$cntREC][$i] = $DataArray[$i];
			}

			//print $XMLArray[4][1];

			XML_DBwriteFile($XMLFile, $XMLArray, $DB, $REC, $FLD, $cntREC + 1, $cntFLD);

			return true;

		}


		switch ($Mode) {
	
			case "OVERWRITE":

 			 	/*
  				 * if user propose to OVERWRITE @ pos 3 means that Record 3 would
				 * be overwritten with the new record. Record 3 is Record[2][?]
				 * as the array starts from 0 therefore 1 must be deducted.
				 *
				 */

				
				//Cannot exceed the last record.
		
				if ($PosToAdd > $cntREC) return false;
				
				$PosToAdd -= 1;

				for ($i = 0; $i < $cntFLD; $i++) {
					$XMLArray[$PosToAdd][$i] = $DataArray[$i];
				}

				XML_DBwriteFile($XMLFile, $XMLArray, $DB, $REC, $FLD, $cntREC, $cntFLD);
				
				break;
			

			case "INSERT":

 			 	/*
  				 * if user propose to INSEERT @ pos 3 means that Record 3 would
				 * be pushed to record 4 and all following records would be pushed downwards 
				 * with the new record at record 3. Record 3 is Record[2][?]
				 * as the array starts from 0 therefore 1 must be deducted.
				 *
				 */
				
				//Cannot exceed the last record.
		
				if ($PosToAdd > $cntREC) return false;
				
				$PosToAdd -= 1;

				for ($i = 0; $i < $cntREC + 1; $i++) {

					//Before the record where the new record is to be 
					//added copy the array as per normal
					//When reach then copy the required item and when passed
					//copy 1 item before as the pointer is at the next item
					//and since for loop conditions has accomodated for 1 
					//more would not affect.

					if ($i <  $PosToAdd) $NewArray[$i] = $XMLArray[$i];

					if ($i == $PosToAdd) $NewArray[$i] = $DataArray;

					if ($i >  $PosToAdd) $NewArray[$i] = $XMLArray[$i - 1];
				}


				XML_DBwriteFile($XMLFile, $NewArray, $DB, $REC, $FLD, $cntREC + 1, $cntFLD);

				break;
		

		}


	}





	function XML_DBdeleteRecord($XMLFile, $RecNum) {

		$XMLArray = XML_DBarrayDump($XMLFile, $DB, $REC, $cntREC, $cntFLD, $FLD);

	 	/*
 		 * if user propose to DELETE record 3 means that Record 4 would
		 * be pushed to record 3 and all following records would be pushed upwards 
		 * Record 3 is Record[2][?] as the array starts from 0 therefore 1 must be 
		 * deducted.
		 *
		 */
				
		//Cannot exceed the last record.
		
		if ($RecNum > $cntREC) return false;
				
		$RecNum -= 1;

		for ($i = 0; $i < $cntREC - 1; $i++) {

			//to Delete the record simply not include it.
			//there fore when record pointer is there take the next record and so on

			if ($i <  $RecNum) $NewArray[$i] = $XMLArray[$i];

			if ($i >= $RecNum) $NewArray[$i] = $XMLArray[$i + 1];

		}

		XML_DBwriteFile($XMLFile, $NewArray, $DB, $REC, $FLD, $cntREC - 1, $cntFLD);

	}




	function XML_DBSearch($XMLFile, $FieldName, $SearchTerm) {

		$XMLArray = XML_DBarrayDump($XMLFile, $DB, $REC, $cntREC, $cntFLD, $FLD);		

		// return X means field not found
		// return N means unable to locate search term in records
		// return integer means that search term has been found and number is record number

		$foundfield = false;

		for ($flds = 0; $flds < $cntFLD; $flds++) {
			if (trim($FieldName) == trim($FLD[$flds])) {
				$TFieldIndex = $flds;
				$foundfield  = true;
				break;
			}
		}


		if ($foundfield) {

			$foundrecord = false;
			$SearchTerm  = trim(strtoupper($SearchTerm));

			for ($i = 0; $i < $cntREC; $i++) {

				if (trim(strtoupper($XMLArray[$i][$TFieldIndex])) == $SearchTerm) {
					$TRecordIndex = $i;
					$foundrecord  = true;
					break;
				}
				
			}

			if ($foundrecord) {
				return $TRecordIndex + 1;   //Add 1 as only in PHP array elements start at 0 cannot have record 0
			} else {
				return "N";
			}

		} else {

			return "X";

		}


	}




?>







