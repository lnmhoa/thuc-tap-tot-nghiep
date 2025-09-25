<?php

function confirm($title = "Thông báo", $text = "", $icon, $message1, $message2, $link1, $link2)
{
    echo '
    <script>
    Swal.fire({
        title: "' . $title . '",
        icon: "' . $icon . '",
        text: "' . $text . '",
        showDenyButton: true,
        confirmButtonText: "' . $message1 . '",
        denyButtonText: "' . $message2 . '"
      }).then((result) => {
        if (result.isConfirmed) {
            window.location.assign("' . $link1 . '");
        } else if (result.isDenied) {
            window.location.assign("' . $link2 . '");
        }
      });
    </script>        
    ';
}

function confirmNotLoad($text = "", $message1, $message2)
{
    echo '
    <script>
    Swal.fire({
        title: "Thông báo",
        icon: "warning",
        text: "' . $text . '",
        showDenyButton: true,
        confirmButtonText: "' . $message1 . '",
        denyButtonText: "' . $message2 . '"
      });
    </script>        
    ';
}

function success($msg, $link)
{
    echo '<script>
        Swal.fire({
            title: "Thông báo",
            text: "' . $msg . '",
            icon: "success",
            showConfirmButton: true,
        }).then(function(){
            window.location.assign("' . $link . '");
        });
    </script>';
}

function error($msg, $link)
{
    echo '<script>
        Swal.fire({
            title: "Thông báo",
            text: "' . $msg . '",
            icon: "error",
            showConfirmButton: true,
        }).then(function(){
            window.location.assign("' . $link . '");
        });
    </script>';
}

function warning($msg, $link)
{
    echo '<script>
        Swal.fire({
            title: "Thông báo",
            text: "' . $msg . '",
            icon: "warning",
            showConfirmButton: true,
        }).then(function(){
            window.location.assign("' . $link . '");
        });
    </script>';
}

function errorNotLoad($msg)
{
    echo '<script>
        Swal.fire({
            title: "Thông báo",
            text: "' . $msg . '",
            icon: "error",
            showConfirmButton: true,
        })
    </script>';
}

function warningNotLoad($msg)
{
    echo '<script>
        Swal.fire({
            title: "Thông báo",
            text: "' . $msg . '",
            icon: "warning",
            showConfirmButton: true,
        })
    </script>';
}