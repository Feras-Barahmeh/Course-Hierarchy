<?php

// Language
const APP_DEFAULT_LANGUAGE = "english";

// language column in DB
const LANGUAGE_NAME_COLUMNS_DB = "language";

// Email

const TLD_STUDENT_EMAIL = "stu.ttu.edu.jo";
define("LEN_TDL_STUDENT_EMAIL", strlen(TLD_STUDENT_EMAIL));

const TLD_INSTRUCTOR_EMAIL = "ins.ttu.edu.jo";
define("LEN_TDL_INSTRUCTOR_EMAIL", strlen(TLD_INSTRUCTOR_EMAIL));
const TLD_ADMIN_EMAIL = "adm.ttu.edu.jo";
define("LEN_TDL_ADMIN_EMAIL", strlen(TLD_ADMIN_EMAIL));

const TLD_GUIDE_EMAIL = "gui.ttu.edu.jo";
define("LEN_TDL_GUIDE_EMAIL", strlen(TLD_GUIDE_EMAIL));

const TLD_PARTS = ["stu", "adm", "ins", "gui"];