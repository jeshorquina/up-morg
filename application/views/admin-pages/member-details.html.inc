<div class="container" id="member-details-container" data-member-id="<?= $page['details']['member_id'] ?>">

    <div class="card">

        <div class="breadcrumb">
            <span class="crumb">
                <a href="<?= $page['urls']['member_details'] ?>" >Member Management</a>
            </span>
            <span class="crumb">
                <span class="member-name"></span>
            </span>
        </div>

        <hr>

        <h2><span class="member-name"></span>'s Details</h2>

        <form id="modify-member-form">

            <div class="flex-container">

                <div class="form-group flex flex-third">
                    <span class="form-label">First Name</span>
                    <input type="text" name="first-name" id="first-name" class="form-input" placeholder="Enter first name" required="required">
                    <span class="form-error" id="first-name-error"></span>
                </div>

                <div class="form-group flex flex-third">
                    <span class="form-label">Middle Name</span>
                    <input type="text" name="middle-name" id="middle-name" class="form-input" placeholder="Enter middle name">
                    <span class="form-error" id="middle-name-error"></span>
                </div>

                <div class="form-group flex flex-third">
                    <span class="form-label">Last Name</span>
                    <input type="text" name="last-name" id="last-name" class="form-input" placeholder="Enter last name" required="required">
                    <span class="form-error" id="last-name-error"></span>
                </div>

            </div>

            <div class="flex-container">

                <div class="form-group flex flex-half">
                    <span class="form-label">Email Address</span>
                    <input type="text" name="email-address" id="email-address" class="form-input" placeholder="sample@upmorg.com" required="required">
                    <span class="form-error" id="email-address-error"></span>
                </div>

                <div class="form-group flex flex-half">
                    <span class="form-label">Phone Number</span>
                    <input type="text" name="phone-number" id="phone-number" class="form-input" placeholder="Enter phone number" required="required">
                    <span class="form-error" id="phone-number-error"></span>
                </div>

            </div>

            <input type="submit" class="button button-success no-margin margin-top-medium" value="Edit Member">

            <input type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>">

        </form>

    </div>

</div>