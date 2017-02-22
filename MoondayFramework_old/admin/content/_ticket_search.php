<?php
if(!@$_SESSION['loggedin']) header("Location: logout.php");

//*** Retrives the page search_field from the URL query string.
if (!isset($search_field)) { $search_field = $_GET['search_field']; } else { return (0); }

//*** Retrives the search_value var from the URL query string.
if (!isset($search_value)) { $search_value = $_GET['search_value']; } else { return (0); }

//*** Retrives the status_id var from the URL query string.
if (!isset($status_id)) { $status_id = $_GET['status_id']; } else { return (0); }

?>

<!-- Ticket Search .php -->
<!--<table border="5">-->
<!--<tr>-->
<!--<td>-->
<!--<span>-->

<!--</span>-->
<!--</td>-->
<!--</tr>--> <!--</table>-->

<!-- STOP Ticket Search .php -->

<table border="1"> <tr> <td><span> <pre>
  Hey  <?php echo $coreEngine->ticketObject->showUserQueueTickets(); ?>
</pre> </span> </td> </tr> </table>