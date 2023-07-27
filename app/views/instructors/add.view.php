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
                <input type="text" class="form-control" id="FirstName" name="FirstName" value="Feras" required>
                <div class="valid-feedback">
                    Looks good!
                </div>
            </div>

            <div class="col-md-4">
                <label for="LastName" class="form-label mb-1">Last name</label>
                <input type="text" class="form-control" id="LastName" name="LastName"   value="Barahmeh" required>
                <div class="valid-feedback">
                    Looks good!
                </div>
            </div>


            <div class="col-md-4">
                <label for="Email" class="form-label mb-1">Email</label>
                <input type="email" class="form-control" id="Email" name="Email" value="ferasbarahmhe55@gmail.com" required>
                <div class="invalid-feedback">
                    Please provide a valid city.
                </div>
            </div>


            <div class="col-md-4">
                <label for="Password" class="form-label mb-1">Password</label>
                <input type="password" class="form-control" id="Password" name="Password" value="123456"  required>

                <button class="show-password" show-password="false" description="show Password">
                    <i class="fa-solid fa-eye"></i>
                </button>

                <div class="valid-feedback">
                    Looks good!
                </div>
            </div>

            <div class="col-md-4">
                <label for="ConfirmPassword" class="form-label mb-1">Confirm Password</label>
                <input type="password" class="form-control" id="ConfirmPassword" name="ConfirmPassword"  value="123456" required>
                <button class="show-password" show-password="false" description="show Password">
                    <i class="fa-solid fa-eye"></i>
                </button>
                <div class="valid-feedback">
                    Looks good!
                </div>
            </div>


            <div class="col-md-4">
                <label for="NationalIdentificationNumber" class="form-label mb-1">National Identification Number</label>
                <input type="text" class="form-control" id="NationalIdentificationNumber" name="NationalIdentificationNumber" value="1152892526" required>
                <div class="invalid-feedback">
                    Please provide a valid city.
                </div>
            </div>


            <div class="col-md-2">
                <label for="State" class="form-label mb-1">State</label>
                <input type="text" class="form-control" id="State" name="State" value="Tafila" required>
                <div class="invalid-feedback">
                    Please provide a valid State.
                </div>
            </div>

            <div class="col-md-2">
                <label for="Country" class="form-label mb-1">Country</label>
                <input type="text" class="form-control" id="Country" name="Country" value="Zarqa" required>
                <div class="invalid-feedback">
                    Please provide a Country.
                </div>
            </div>

            <div class="col-md-2">
                <label for="PhoneNumber" class="form-label mb-1">PhoneNumber</label>
                <input type="text" class="form-control" id="PhoneNumber" name="PhoneNumber" value="0785102996" required>
                <div class="invalid-feedback">
                    Please provide a valid PhoneNumber.
                </div>
            </div>

            <div class="col-md-6">
                <label for="Address" class="form-label mb-1">Address</label>
                <input type="text" class="form-control" id="Address" name="Address" value="Zarqa-Jordan" required>
                <div class="invalid-feedback">
                    Please provide a valid Address.
                </div>
            </div>

            <div class="col-md-2">
                <label for="DOB" class="form-label mb-1">DOB</label>
                <input type="text" class="form-control" id="DOB" name="DOB" value="11/6/2002" required>
                <div class="invalid-feedback">
                    Please provide a DOB.
                </div>
            </div>

            <div class="col-md-2">
                <label for="HireDate" class="form-label mb-1">Hire Date</label>
                <input type="text" class="form-control" id="HireDate" name="HireDate" value="10/10/2020" required>
                <div class="invalid-feedback">
                    Please provide a DOB.
                </div>
            </div>


            <div class="col-md-2">
                <label for="Salary" class="form-label mb-1">Salary</label>
                <input type="number" class="form-control" id="Salary" name="Salary" value="1000" required>
                <div class="invalid-feedback">
                    Please provide a DOB.
                </div>
            </div>


            <div class="col-md-2">
                <label for="YearsOfExperience" class="form-label mb-1">Years Of Experience</label>
                <input type="number" class="form-control" id="YearsOfExperience" name="YearsOfExperience" min="0" value="5" required>
                <div class="invalid-feedback">
                    Please provide a DOB.
                </div>
            </div>


            <div class="col-md-2">
                <label for="IfFullTime" class="form-label mb-1">If Full Time</label>
                <select class="form-select" id="IfFullTime" name="IfFullTime" required>
<!--                    <option selected disabled value="">Choose...</option>-->
                    <option value="1" selected>Yes</option>
                    <option value="0">No</option>
                </select>
                <div class="invalid-feedback">
                    Please select a valid state.
                </div>
            </div>

            <div class="col-md-2">
                <label for="IsActive" class="form-label mb-1">Is Active</label>
                <select class="form-select" id="IsActive" name="IsActive" required>
<!--                    <option selected disabled value="">Choose...</option>-->
                    <option value="1" selected>Yes</option>
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