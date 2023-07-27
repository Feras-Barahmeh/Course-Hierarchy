@extend('layout.header')@
@extend('layout.nav')@
@extend('layout.aside')@

<main class="">
    <h1 class="main-title">
        <i class="fa-solid fa-user-plus"></i>
        <span class="">
            Add Instructor
        </span>
    </h1>

    <div class="container mt-20 container-form">
        <?php
            if ($messages != null) {
                foreach ($messages as $message) {
                    ?>
                        <div class="alert alert-danger plr-10 ptb-5 " role="alert">
                            <?= $message[0]  ?>
                        </div>
                    <?php
                }
            }
        ?>
        <form class="row g-3" method="POST" >
            <div class="col-md-4">
                <label for="FirstName" class="form-label mb-1">First name</label>
                <input type="text" class="form-control" id="FirstName" between="2,50" name="FirstName" value="<?= $controller->getStorePost("FirstName") ?>" required autocomplete="none">
                <div class="valid-feedback">
                    Looks good!
                </div>
                <div class="invalid-feedback">
                    First Name must between 2 and 50 character
                </div>
            </div>

            <div class="col-md-4">
                <label for="LastName" class="form-label mb-1">Last name</label>
                <input type="text" class="form-control" id="LastName" between="2,50" name="LastName" value="<?= $controller->getStorePost("LastName") ?>" required>
                <div class="valid-feedback">
                    Looks good!
                </div>
                <div class="invalid-feedback">
                    Last Name must between 2 and 50 character
                </div>
            </div>


            <div class="col-md-4">
                <label for="Email" class="form-label mb-1">Email</label>
                <input type="email" class="form-control" id="Email" name="Email" email-input value="<?= $controller->getStorePost("Email") ?>" required>
                <div class="invalid-feedback">
                    Please provide a valid
                </div>
                <div class="valid-feedback">
                    Looks good!
                </div>
            </div>


            <div class="col-md-4">
                <label for="Password" class="form-label mb-1">Password</label>
                <input type="password" class="form-control" id="Password" name="Password" value="<?= $controller->getStorePost("Password") ?>"  required>

                <button class="show-password" show-password="false" description="show Password">
                    <i class="fa-solid fa-eye"></i>
                </button>

                <div class="valid-feedback">
                    Looks good!
                </div>
            </div>

            <div class="col-md-4">
                <label for="ConfirmPassword" class="form-label mb-1">Confirm Password</label>
                <input type="password" class="form-control" id="ConfirmPassword" name="ConfirmPassword"  value="<?= $controller->getStorePost("ConfirmPassword") ?>" required>
                <button class="show-password" show-password="false" description="show Password">
                    <i class="fa-solid fa-eye"></i>
                </button>
                <div class="valid-feedback">
                    Looks good!
                </div>
            </div>


            <div class="col-md-4">
                <label for="NationalIdentificationNumber" class="form-label mb-1">National Identification Number</label>
                <input type="text" class="form-control" id="NationalIdentificationNumber" name="NationalIdentificationNumber"  between="11, 11" value="<?= $controller->getStorePost("NationalIdentificationNumber") ?>" required>
                <div class="invalid-feedback">
                    National Identification Number Must be 11 digit
                </div>
                <div class="valid-feedback">
                    Looks good!
                </div>
            </div>


            <div class="col-md-2">
                <label for="State" class="form-label mb-1">State</label>
                <input type="text" class="form-control" id="State" name="State" value="<?= $controller->getStorePost("State") ?>" required>
                <div class="invalid-feedback">
                    Please provide a valid State.
                </div>
            </div>

            <div class="col-md-2">
                <label for="Country" class="form-label mb-1">Country</label>
                <input type="text" class="form-control" id="Country" name="Country" value="<?= $controller->getStorePost("Country") ?>" required>
                <div class="invalid-feedback">
                    Please provide a Country.
                </div>
            </div>

            <div class="col-md-2">
                <label for="PhoneNumber" class="form-label mb-1">PhoneNumber</label>
                <input type="text" class="form-control" id="PhoneNumber" between="10, 10" name="PhoneNumber" value="<?= $controller->getStorePost("PhoneNumber") ?>" required>
                <div class="invalid-feedback">
                    Phone number Must be 10 character
                </div>
                <div class="valid-feedback">
                    Looks good!
                </div>
            </div>

            <div class="col-md-6">
                <label for="Address" class="form-label mb-1">Address</label>
                <input type="text" class="form-control" id="Address" name="Address" value="<?= $controller->getStorePost("Address") ?>" required>
                <div class="invalid-feedback">
                    Please provide a valid Address.
                </div>
            </div>

            <div class="col-md-2">
                <label for="DOB" class="form-label mb-1">DOB</label>
                <input type="text" class="form-control" id="DOB" name="DOB" value="<?= $controller->getStorePost("DOB") ?>" required>
                <div class="invalid-feedback">
                    Please provide a DOB.
                </div>
            </div>

            <div class="col-md-2">
                <label for="HireDate" class="form-label mb-1">Hire Date</label>
                <input type="text" class="form-control" id="HireDate" name="HireDate" value="<?= $controller->getStorePost("HireDate") ?>" required>
                <div class="invalid-feedback">
                    Please provide a DOB.
                </div>
            </div>


            <div class="col-md-2">
                <label for="Salary" class="form-label mb-1">Salary</label>
                <input type="number" class="form-control" id="Salary" name="Salary" value="<?= $controller->getStorePost("Salary") ?>" required>
                <div class="invalid-feedback">
                    Please provide a DOB.
                </div>
            </div>


            <div class="col-md-2">
                <label for="YearsOfExperience" class="form-label mb-1">Years Of Experience</label>
                <input type="number" class="form-control" id="YearsOfExperience" name="YearsOfExperience" min="0" value="<?= $controller->getStorePost("YearsOfExperience") ?>" required>
                <div class="invalid-feedback">
                    Please provide a DOB.
                </div>
            </div>


            <div class="col-md-2">
                <label for="IfFullTime" class="form-label mb-1">If Full Time</label>
                <select class="form-select" id="IfFullTime" name="IfFullTime" required>
                    <option selected disabled value="<?= $controller->getStorePost("IfFullTime") ?>">
                        <?= $controller->getStorePost("IfFullTime") ? 'Yes' : "No" ?>
                    </option>
                    <option value="1">Yes</option>
                    <option value="0">No</option>
                </select>
                <div class="invalid-feedback">
                    Please select a valid state.
                </div>
            </div>

            <div class="col-md-2">
                <label for="IsActive" class="form-label mb-1">Is Active</label>
                <select class="form-select" id="IsActive" name="IsActive" required>
                    <option selected disabled value="<?= $controller->getStorePost("IsActive") ?>">
                        <?= $controller->getStorePost("IsActive") ? 'Yes' : "No" ?>
                    </option>
                    <option value="1">Yes</option>
                    <option value="0">No</option>
                </select>
                <div class="invalid-feedback">
                    Please select a valid state.
                </div>
            </div>


            <div class="col-12">
                <button class="main-btn" name="add" type="submit">Submit form</button>
            </div>
        </form>
    </div>
</main>

@extend('layout.footer')@