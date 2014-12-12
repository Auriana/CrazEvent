<script>
    var notificationsRead = new Object();
    function readNotification(idNotification) {
        //do not query the server if notification already received
        if(!(idNotification in notificationsRead)) {
            $.ajax({
            type: "GET",
            url: '/notification/read_notification?id='+idNotification,
            dataType: "json",

            success: function (obj, textstatus) {
                          if( !('error' in obj) ) {
                              notificationsRead[idNotification] = obj.result.content;
                              $('#notificationContent').html(obj.result.content);
                          }
                          else {
                              console.log(obj.error);
                          }
                    }
            });
        } else {
            $('#notificationContent').html(notificationsRead[idNotification]);
        }
    }
    
    $(document).ready(function(){
        $('.notification-notRead').click(function() {
            $(this).addClass('notification-read');
            $(this).removeClass('notification-notRead');
        });
    });
</script>
<div class="container theme-showcase" role="main">
	<div class="col-md-10 white-bloc centred">
		<h1 class="text-centred">
			Mes notifications
		</h1>
        <?php
            if(isset($notifications)) {
                echo "<table>";
                echo "<tr><th>Sujet</th><th>Expéditeur</th><th>Date</th></tr>";
				foreach ($notifications as $notification) {
                    echo '<tr onclick="readNotification('.$notification->messageId.')" class="'. ($notification->is_read == 1 ? 'notification-read' : 'notification-notRead') .'">';
                    echo "<td>".$notification->subject."</td>";
                    echo "<td>".$notification->senderFirstname." ".$notification->senderSurname."</td>";
                    echo "<td>".$notification->date."</td>";
                    echo "</tr>";
				}
                echo "</table>";
			}
        ?>
        <div id="notificationContent" style="border:1px solid black;">
        </div>
	</div>