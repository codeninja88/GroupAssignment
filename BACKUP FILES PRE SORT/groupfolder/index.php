

<?php
    include "includes/1_htmlAndHead.php";
?>



<body>

    //Header section
    <a id="homeLink" href="index.html">
    <div class="head">
        <h1>Townsville Community Music Centre</h1>
        <div id="Logo">
            <img src="images/TCMC.gif" alt="Logo">
        </div>
    </div>
    </a>

    //Sign-up / login  / notices
    <div class="belowHeader">
        <div class="rightColumn">
            <div id="signUp">
                <a style="display:block" href="members.html">
                    Sign-Up
                </a>
            </div>

            <div id="currentMembers">
                Current Members
            </div>

            <form id="loginform">
                <label class="username" for="username">User Name:</label>
                <input type="text" name="username" id="username" size="19" placeholder="Email" />
                <br>
                <br>
                <label class="password" for="password">Password:</label>
                <input type="password" name="password" size="19" />
                <br>
                <br>
                <input type="submit" value="Login">
            </form>

            //Notices
            <div id="notice">
                Recent Notices
            </div>
            <div id="notices">
                <a id="submit" href="submitnotices.html">Add Notice</a><br>
                <p>
                    <div class="noticeDates">
                        <p>
                            Posted 24-Mar-15
                        </p>
                    </div>
                    <strong>Volunteer Singers / Musicians<br></strong>
                    <br>
                    Our Parish Priest, Fr Mick Peters, is trying to development and foster a community for our 6 PM Vigil Mass at St Josephs on the Strand.
                    <br>
                    <a href="notices.html">Read more...</a>
                    <br>
                </p>
                <p>
                    <div class="noticeDates">
                        <p>
                            Posted 21-March-15
                        </p>
                    </div>
                    <strong>CALL OUT FOR MUSOS</strong><br>
                    <br>
                    Calling all Musos, entertainers, performers. We are looking to book performers/musicians/entertainers for a family friendly festival at the       Ingham Tyto Wetlands on the 23rd of May.
                    <br>
                    <a href="notices.html">Read more...</a>
                    <br>
                </p>
                <p>
                    <div class="noticeDates">
                        <p>
                            Posted 17-Mar-15
                        </p>
                    </div>
                    <strong>Chord Organ Rouvas Academy of Singing</strong>
                    <br>
                    <br>
                    I have been in the music industry in Sydney for over 30 years in the capacity of singing teacher, stage performer, singer and musician.
                    <br>
                    <a href="notices.html">Read more...</a>
                </p>
            </div>
        </div>



        // Navigation Bar
    <?php
        include "navBar.php";
    ?>


        // Main Content
        <div class="Content">
            <h2>Home</h2>
            <div style="float: right; width: 500px; border: 1px solid black; padding-bottom: 30px;">
                <div id="featured">Featured Artist</div>
                    <br>
                    <div style="padding-left: 30px; padding-right: 30px;">
                        <img src="images/Aquapella01.jpg" alt="Aquapello" style="width: 70%; height: auto;">
                        <br>
                        <br>
                        <strong>Aquapello</strong>
                        <br>
                        <br>
                        Aquapella are 50 singers from the Townsville area bringing you a cappella world music at its very best: inspiring and uplifting harmonies from around the globe.
                    </div>
                </div>
                <p>
                With the support of the Townsville City Council, we work from an office in the Civic Theatre building.
                <br>
                (Take the lift near the ticket office to Level 2)
                <br>
                <br>
                "Normal" office hours -
                9.30 -2.30 Monday - Wednesday
                <br>
                Any other time just call 0402 255 182
                <br>
                <br>
                <strong>Contact Details</strong>
                <br>
                <br>
                Phone:   07 4724 2086
                <br>
                Mobile:    0402 255 182
                <br>
                e-mail us with your query
                <br>
                Postal Address:  PO Box 1006, Townsville, Qld 4810
                <br>
                Address:  Townsville Civic Theatre, 41 Boundary Street, Townsville, Qld 4810
                <br>
                <br>
                Are you new to Townsville?
                <br>
                General information about Townsville is available at -
                <br>
                http://www.townsville.qld.gov.au/townsville/infocentre/Pages/default.aspx
                <br>
                <br>
                Townsville has a population of about 200,000 and is growing at about 1 suburb per year, so there is a lot of musical activity. All private         schools and most government schools have music teachers. The larger private schools are Townsville Grammar, the Cathedral School and Ryan         Catholic College. The larger public high schools are Kirwan and Pimlico.
                <br>
                <br>
                Music Teachers Association of Qld is a good source of information for local music teachers.
                The Townsville Branch contact is the Secretary (Ms Margery Jorgensen)
                <br>
                <br>
                Phone (07) 47790382
                <br>
                Email: mjo11750@bigpond.net.au
                <br>
                Another active teachers’ organisation is the Kodaly Music Education Institute of Australia -
                <br>
                www.kodaly.org.au/
                <br>
                Information on their Townsville Chapter can be found at -
                <br>
                http://webapps.townsville.qld.gov.au/CommunityDirectory/Organisation/-
                <br>
                OrganisationDetails/1185
                <br>
                <br>
                Some local businesses also employ or assist music teachers. Try these -
                <br>
                heather@thekeyboardshop.com.au
                <br>
                and www.artiesmusiconline.com.au/
                <br>
                <br>
                Busking is permitted at several public spaces around the city with a Buskers Permit from the city council - phone 4727 9680.
                <br>
                There is no age limit, but buskers 16 and under will need to be accompanied by a parent/guardian.
            </p>
        </div>
    </div>
</body>
</html>
