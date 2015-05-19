<?php
session_start();
include_once "includes/functions.php";
if ($_SESSION['loginState'] === "Logged in") {
    redirectTo("myAccount.php");
}
include "includes/headerALL.php";


?>



<div class="Content">
    <h2>Members</h2>

    <p>
        <strong>
            Membership Application Form
        </strong><br>
        <br>
        You can support the Music Centre by becoming a Member and derive some benefits for yourself at the same time.
        Your subscription helps to keep us operating and we provide substantial discounts whenever possible.<br>
        <br>
        For the Music Centre's own events, Members' ticket discounts can be as high as 50%!<br>
        <br>
        Paid Individual Membership subscription is $25 per year.<br>
        <br>
        The Music Centre is also registered as a Deductible Gift Recipient. Any extra donations are tax-deductible!<br>
        *Required fields

    <form action="signUpApplicationHandler.php" method="post">
        <table id="signupTable">
            <tr>
                <td><label class="username" for="username">User Name (email)*:</label></td>
                <td><input type="email" name="username" id="username" size="20" placeholder="someone@somewhere.com"
                           required/></td>
            </tr>
            <tr>
                <td><label class="password" for="password">Password*:</label></td>
                <td><input type="password" name="password" size="20" required/></td>
                
            </tr>
            <tr>
                <td><label class="firstname" for="firstname">First Name*:</label></td>
                <td><input type="text" name="userFName" id="firstname" size="20" required/></td>
            </tr>
            <tr>
                <td><label class="surname" for="surname">Surname*:</label></td>
                <td><input type="text" name="userLName" id="surname" size="20" required/></td>
            </tr>
            <tr>
                <td><label class="phone" for="phone">Phone Number:</label></td>
                <td><input type="text" name="userPrimPhone" id="phone" size="20"/></td>
            </tr>
            <tr>
                <td><label class="mobile" for="mobile">Mobile Number:</label></td>
                <td><input type="text" name="userMob" id="mobile" size="20"/></td>
            </tr>
            <tr>
                <td><label for="userAddress">User Address:</label></td>
                <td><input type="text" name="userAddress" id="userAddress"/></td>
            </tr>
            <!-- Style this sign up button -->
            <!-- usertype check box. -->
        </table>
        User Type:
        Casual: <input type="radio" name="userType" value="casual" checked="checked"/>
        Paid: <input type="radio" name="userType" value="paid"/>
        <input type="submit" name="Signup" value="Signup">
    </form>
    <br>
    <br>
    Paid membership fee ($25 annual)<br>
    <a href="https://www.paypal.com/au/cgi-bin/webscr?cmd=_flow&SESSION=bxFNHj00Vw36P_ZlPc6LMBcBdshuRMv9n4PhLPQUccFkg2NAWsRYh1XZ7KW&dispatch=50a222a57771920b6a3d7b606239e4d529b525e0b7e69bf0224adecfb0124e9b61f737ba21b08198ecd47ed44bac94cd6fd721232afa4155">
        <img src="images/Pay.gif" alt="pay"><br>
    </a>
    <br>
    Tax-deductible donation<br>
    <a href="https://www.paypal.com/au/cgi-bin/webscr?cmd=_flow&SESSION=-VqFZ99thsK2gbyncTu73G1UgGci5nVqYP5JD1k-_PzYeb-gf558bvWKTAS&dispatch=5885d80a13c0db1f8e263663d3faee8d96f000117187ac9edec8a65b311f447e">
        <img src="images/donate.gif" alt="Donate">
    </a>
    </p>
</div>
</div>
</div>
</body>
</html>
