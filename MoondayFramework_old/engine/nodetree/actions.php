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
/**
 * Actions script for node tree application
 * 
 * Use after config.php
 */
// variables
$sAction 		= isset( $_REQUEST['action'] ) ? $_REQUEST['action'] : '';
$iSourceId 		= isset( $_REQUEST['source_id'] ) ? $_REQUEST['source_id'] : 0;
$iTargetId		= isset( $_REQUEST['target_id'] ) ? $_REQUEST['target_id'] : 0;
$sNodeTitle 	= isset( $_REQUEST['node_title'] ) ? $_REQUEST['node_title'] : '';
$bOnlySubnodes 	= isset( $_REQUEST['only_subnodes'] ) ? strtolower($_REQUEST['only_subnodes']) : '';
$bOnlySubnodes 	= in_array( $bOnlySubnodes, array( 'yes', 'true', '1' ) );
$sMsg 			= '';
$bSuccess 		= true;

if( $sAction != '' ) {
	
	$oNode = $oNT;
	
	switch($sAction) {
		case 'add':
			$iTargetId = $iTargetId == $sRootId ? 0 : $iTargetId;
			if( $iId = $oNode->add_node($iTargetId,$sNodeTitle) ) {
				$sMsg .= 'New node added: '.$iId;
			} else {
				$sMsg .= 'Adding node failed';
				$bSuccess = false;
			}
			break;
			
		case 'edit':
			$iTargetId = $iTargetId == $sRootId ? 0 : $iTargetId;
			if( $bSuccess = $oNode->edit_node($iTargetId,$sNodeTitle) ) {
				$sMsg .= 'Node edited';
			} else {
				$sMsg .= 'Editing node failed';
			}
			break;
			
		case 'delete':
		case 'delete_subnodes':
			$iTargetId = $iTargetId == $sRootId ? 0 : $iTargetId;
			if( $bSuccess = $oNode->delete_node($iTargetId,$bOnlySubnodes) ) {
				$sMsg .= 'Node deleted';
			} else {
				$sMsg .= 'Deleting node failed';
			}
			break;
			
		case 'move':
		case 'move_subnodes':
			if( $bSuccess = $oNode->move_node($iSourceId,$iTargetId,$bOnlySubnodes) ) {
				$sMsg .= 'Node moved';
			} else {
				$sMsg .= 'Moving node failed';
			}
			break;
			
		case 'copy':
		case 'copy_subnodes':
			if( $bSuccess = $oNode->copy_node($iSourceId,$iTargetId,0,$bOnlySubnodes) ) {
				$sMsg .= 'Node copied';
			} else {
				$sMsg .= 'Copying node failed';
			}
			break;
			
		case 'order_up':
			if( $bSuccess = $oNode->order_up($iTargetId) ) {
				$sMsg .= 'Node ordered up';
			} else {
				$sMsg .= 'Ordering node up failed';
			}
			break;
			
		case 'order_down':
			if( $bSuccess = $oNode->order_down($iTargetId) ) {
				$sMsg .= 'Node ordered down';
			} else {
				$sMsg .= 'Ordering node down failed';
			}
			break;
		
		case 'custom':
			$sMsg .= 'Custom action not defined';
			break;
			
		default:
			$sMsg .= 'Default action triggered';
			break;
	}
	unset( $oNode );
}
// create message string
$sClass = $bSuccess ? 'message_ok' : 'message_fail';
$sMsg 	=  $sMsg != '' ? '<p class="'.$sClass.'">'.$sMsg.'</p>' : '';

?>