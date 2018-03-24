<?xml version="1.0" encoding="UTF-8" ?>
for $fam in doc("../basex/company/dependent.xml"),
    $emp in doc("../basex/company/employee.xml"),
    $dep in doc("../basex/company/department.xml"),
    $mgr in doc("../basex/company/employee.xml")
where 
