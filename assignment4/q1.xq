(:
    For each dependent, output
       - dependent name
       - firstname, lastname of the corresponding employee
       - firstname, lastname of the manager for that employee
:)
<results>
  {
    for $fam in doc("../company/dependent.xml")//dependent,
        $emp in doc("../company/employee.xml")//employee,
        $dep in doc("../company/department.xml")//department,
        $mgr in doc("../company/employee.xml")//employee
    where $fam/essn = $emp/ssn and $emp/dno = $dep/dnumber and $dep/mgrssn = $mgr/ssn
    return
    <row>
       <dependent name="{$fam/dependent_name}"/>
       <emp fname="{$emp/fname}" lname="{$emp/lname}"/>
       <mgr fname="{$mgr/fname}" lname="{$mgr/lname}"/>
    </row>
  }
</results>
