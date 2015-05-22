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

    <form action="signUpApplicationHandler.php" id="signupApplicationForm" method="post">
        <table id="signupTable">
            <tr>
                <td>User Name (email)*:</td>
                <td class="rightSignUpColumn"><input type="email" id="userEmail" name="username"  size="20" placeholder="someone@somewhere.com"
                           required/></td>
            </tr>
            <tr>
                <td>Password*:</td>
                <td class="rightSignUpColumn"><input type="password" name="password" id="passwordInput" size="20" required/><span id="passwordErrorSpan"></span></td>
                
            </tr>
            <tr>
                <td>Confirm Password*:</td>
                <td class="rightSignUpColumn"><input type="password" name="password" id="confirmPasswordInput" size="20" required/></td>
                
            </tr>
            <tr>
                <td>First Name*:</td>
                <td class="rightSignUpColumn"><input type="text" name="userFName" size="20" required/></td>
            </tr>
            <tr>
                <td>Surname*:</td>
                <td class="rightSignUpColumn"><input type="text" name="userLName" size="20" required/></td>
            </tr>
            <tr>
                <td>Phone Number:</td>
                <td class="rightSignUpColumn"><input type="text" name="userPrimPhone" size="20"/></td>
            </tr>
            <tr>
                <td>Secondary Phone Number:</td>
                <td class="rightSignUpColumn"><input type="text" name="userSecPhone" size="20"/></td>
            </tr>
            <tr>
                <td>Mobile Phone:</td>
                <td class="rightSignUpColumn"><input type="text" name="userMobile" size="20"/></td>
            </tr>
            <tr>
                <td>Address:</td>
                <td class="rightSignUpColumn"><textarea id="userAddress" name="userAddress" form="signupApplicationForm" value=''></textarea></td>
            </tr>
            <!-- Style this sign up button -->
            <!-- usertype check box. -->
        </table>
        User Type:
        Casual: <input type="radio" name="userType" value="casual" checked="checked"/>
        Paid: <input type="radio" name="userType" value="paid"/>
        <input type="submit" id="signupButton" name="Signup" value="Signup">
        <script type="text/javascript">

            var confirmPasswordInput = document.getElementById("confirmPasswordInput");
            var emailInput = document.getElementById("userEmail");

            confirmPasswordInput.onblur = function(){

                var confirmPasswordInput = document.getElementById("confirmPasswordInput");
                var passwordErrorSpan = document.getElementById("passwordErrorSpan");
                var passwordInput = document.getElementById("passwordInput");
                var signupButton = document.getElementById("signupButton");
                if(passwordInput.value !== confirmPasswordInput.value){
                    signupButton.disabled = true;
                    passwordErrorSpan.textContent = "Error, passwords don't match, please try again.";
                    passwordErrorSpan.style.color = "rgba(226, 13, 0, 0.69)";
                    passwordInput.style.backgroundColor = "rgba(226, 13, 0, 0.69)";
                    confirmPasswordInput.style.backgroundColor = "rgba(226, 13, 0, 0.69)";
                } else if(confirmPasswordInput.value === passwordInput.value && passwordInput.value !== ""){
                    passwordErrorSpan.textContent = "Passwords match.";
                    passwordErrorSpan.style.color = "rgba(0, 226, 0, 0.69)";
                    signupButton.disabled = false;
                    passwordInput.style.backgroundColor = "rgba(0, 226, 0, 0.69)";
                    confirmPasswordInput.style.backgroundColor = "rgba(0, 226, 0, 0.69)";
                }
            };


            console.log(emailInput);
            document.getElementById("userEmail").onblur = function(){

                var signupButton = document.getElementById("signupButton");
                var regex = /^[a-zA-Z0-9]*\.?[a-z A-Z0-9]*@{1}[a-z A-Z0-9]*(\.{1}[a-zA-Z0-9]+)+$/m;
                var signupButton = document.getElementById("signupButton");
                if(regex.test(this.value)){
                    signupButton.disabled = false;
                    console.log("IF");
                    this.style.backgroundColor = "rgba(0, 226, 0, 0.69)";
                } else if(!regex.test(this.value) && this.value !== "") {
                    this.style.backgroundColor = "rgba(226, 13, 0, 0.69)";
                    signupButton.disabled = true;
                    console.log("Else if");
                } else if(this.value === ""){
                    this.style.backgroundColor = "white";
                    signupButton.disabled = true;
                    console.log("Else.");

                }

            }
        </script>

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
