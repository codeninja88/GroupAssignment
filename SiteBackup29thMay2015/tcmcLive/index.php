
    <?php
        include "includes/headerALL.php";
        require "includes/databaseConnect.php";
    ?>



        <!--MAIN CONTENT--------------------------->
        <div class="Content">
            <h2>Home</h2>
            <div id="featured2">
                <div id='featured'>Featured Artist</div>
                    <br>
                    <div style='padding-left: 30px; padding-right: 30px;'>

                        <?php
                            include "includes/featuredArtist.php";

                               $dbh = null;

                        ?>

                        <p class="">
                            With the support of the Townsville City Council, we work from an off- ice in the Civic Theatre building.
                            <br>
                            (Take the lift near the ticket office<br> to Level 2)
                            <br>
                            <br>
                            Our standard office hours range from
                            9.30am to 2.30pm,<br> Monday to Wednesday.
                            <br>
                            <br>
                            Outside Office hours: <br>0402 255 182 </p>
                            <p>
                            <br>
                            <br>
                            <strong>Contact Details</strong>
                            </p>
                            <p id="contact">
                            <strong>Phone:</strong> 07 4724 2086
                            <br>
                            <strong>Mobile:</strong> 0402 255 182
                            <br>

                            <strong>Postal Address:</strong>
                            <div class='contactAddresses'>PO Box 1006
                            <br>Townsville Qld 4810</div>

                            <strong>Business Address:</strong>
                            <div class='contactAddresses'>
                            Townsville Civic Theatre
                            <br>
                            41 Boundary Street
                            <br>
                            Townsville Qld 4810
                            </div>

                            <br><br><hr></p>
                            <br>
                            <p id="bigger"><strong>
                            Are you new to Townsville?</strong>
                            <br><br></p><p id="generalInfo">
                            General information about Townsville is available at the
                            <a href="http://www.townsville.qld.gov.au/townsville/infocentre/Pages/default.aspx">official Townsville website</a>.    </p>

                        <p class="generalInfo">
                        Townsville has a population of about 200,000 and is growing at about 1 suburb per year, so there is a lot of musical activity. All private         schools and most government schools have music teachers. The larger private schools are Townsville Grammar, the Cathedral School and Ryan         Catholic College. The larger public high schools are Kirwan and Pimlico.</p>
                            <p>
                            Music Teachers Association of Qld is a good source of information for local music teachers.
                            The Townsville Branch contact is the Secretary (Ms Margery Jorgensen)
                            <br>
                            <br>
                            <strong>Phone:</strong> (07) 47790382
                            <br>
                            You can email them at <a href="mailto:mjo11750@bigpond.net.au">mjo11750@bigpond.net.au</a>.
                            <br>
                            <br>
                            Another active teachers’ organisation is the <a href="http://www.kodaly.org.au/">Kodaly Music Education Institute of Australia</a>.
                            <br>
                            Information on their Townsville Chapter can be found <a href="http://webapps.townsville.qld.gov.au/CommunityDirectory/Organisation/OrganisationDetails/1185">here</a>.
                            <br>
                            Some local businesses also employ or assist music teachers. <br><br>You can either email at
                            <a href="mailto:heather@thekeyboardshop.com.au">heather@thekeyboardshop.com.au</a> <br>or visit
                            <a href="http://www.artiesmusiconline.com.au/">Artie's Music Online</a>.
                            <br>
                        </p>
                    </div>
            </div>
        </div>


</body>
</html>
