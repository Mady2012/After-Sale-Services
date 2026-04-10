<?php

$current_user_id = $_SESSION['user_id'];
$current_role = strtolower($_SESSION['role']);

// Count unread notifications for the specific logged-in user
$sqlNotifCount = "SELECT COUNT(*) AS total FROM notification WHERE UserID = :uid AND IsRead = 0";
$stmtNotifCount = $conn->prepare($sqlNotifCount);
$stmtNotifCount->execute(['uid' => $current_user_id]);
$unreadCount = $stmtNotifCount->fetch()['total'];

// Optional: Fetch the last 5 messages to show in a dropdown
$sqlLastNotifs = "SELECT Message, CreatedAt FROM notification WHERE UserID = :uid ORDER BY CreatedAt DESC LIMIT 5";
$stmtLastNotifs = $conn->prepare($sqlLastNotifs);
$stmtLastNotifs->execute(['uid' => $current_user_id]);
$recentNotifs = $stmtLastNotifs->fetchAll();
?>

<div class="navigation">
            <div class="n1">
                <div>
                    <i id="menu-btn" class="fa fa-bars"></i>
                </div>
                <div class="profile">
                  <strong style="color: orange";>AFTER-SALES SERVICE MANAGEMENT SYSTEM</strong>
                </div> 
                
            </div>
           <div class="profile" style="display: flex; align-items: center; gap: 20px;">
    <!-- Notification Wrapper -->
    <div class="notif-wrapper" style="position: relative;">
        <!-- <i class="fa fa-bell" id="notifBtn" style="cursor: pointer; font-size: 20px;"></i> -->
        
        <?php if($unreadCount  > 0): ?>
            <span class="badge" style="position: absolute; top: -10px; right: -10px; background: red; color: white; border-radius: 50%; padding: 2px 6px; font-size: 10px; font-weight: bold;">
                <?= $unreadCount  ?>
            </span>
        <?php endif; ?>

        <!-- The Dropdown Menu -->
        <div id="notifBox" style="display: none; position: absolute; right: 0; top: 30px; width: 280px; background: white; border-radius: 8px; box-shadow: 0 4px 12px rgba(0,0,0,0.15); z-index: 1000; border: 1px solid #eee;">
            <div style="padding: 12px; font-weight: bold; border-bottom: 1px solid #eee; display: flex; justify-content: space-between;">
                Notifications 
                <a href="mark_all_read.php" style="font-size: 10px; color: #007bff; text-decoration: none;">Mark all read</a>
            </div>
            
            <div style="max-height: 300px; overflow-y: auto;">
                <?php if($unreadCount  > 0): ?>
                    <?php foreach($recentNotifs as $n): ?>
                        <div style="padding: 12px; border-bottom: 1px solid #f9f9f9; font-size: 13px; color: #333;">
                            <?= htmlspecialchars($n['Message']) ?>
                            <br><small style="color: #999; font-size: 11px;"><?= date('H:i', strtotime($n['CreatedAt'])) ?></small>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div style="padding: 20px; text-align: center; color: #999; font-size: 13px;">No new notifications</div>
                <?php endif; ?>
            </div>
        </div>
    </div>

               <i class="fa fa-circle-user"></i>
                <!-- <i class="fa fa-sign-out-alt" style="color: orange; font-size: 20px;"></i> -->
            </div>
</div>


<script>
    $(document).ready(function() {
        // Toggle dropdown when clicking the bell
        $('#notifBtn').click(function(e) {
            e.stopPropagation();
            $('#notifBox').fadeToggle(200);
        });

        // Hide dropdown if clicking anywhere else on the page
        $(document).click(function(e) {
            if (!$(e.target).closest('#notifBox').length) {
                $('#notifBox').hide();
            }
        });
    });
</script>