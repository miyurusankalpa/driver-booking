     <div class="header">
	      <h2>Customer Registration</h2>
	 </div>

     <form method="post" action="Register.php">
          <div class="input-group">
          	   <label>First Name</label>
          	   <input type="text" name="Firstname">
          </div>     	

          <div class="input-group">
          	   <label>Last Name</label>
          	   <input type="text" name="Lastname">
          </div> 
       
          <div class="input-group">
          	   <label>Username</label>
          	   <input type="text" name="username">
          </div>

          <div class="input-group">
          	   <label>Email</label>
          	   <input type="text" name="Email">
          </div>

          <div class="input-group">
          	   <label>Password</label>
          	   <input type="password" name="password">
          </div>

          <div class="input-group">
          	   <label>Confirm Password</label>
          	   <input type="password" name="Conpassword">
          </div>

          <div class="input-group">
          	   <button type="submit" name="Register" class="btn">Submit</button>
          </div>
		  <p>
		      If you have alredy registered <a href ="login.php">Sign in</a>
		  </p>
		  
     </form>
