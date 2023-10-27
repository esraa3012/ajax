<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
<!--====form section start====-->
<div class="user-detail">
    <h2>Insert User Data</h2>
    <p id="msg"></p>
    <form id="userForm" method="POST" action="php-script.php" novalidate>
          <label>Last Name</label>
          <input type="text" placeholder="Enter Last Name" name="LastName" required>
          <label>Frist Name</label>
          <input type="text" placeholder="Enter First Name" name="FristName" required>
          <label>Address</label>
          <input type="text" placeholder="Enter Address" name="address" required>
          <button type="submit">Submit</button>
    </form>
        </div>
</div>
<!--====form section start====-->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script type="text/javascript" src="ajax-script.js"></script>
</body>
</html>