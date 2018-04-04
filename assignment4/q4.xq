(:
    For each project, output
       - project name
       - name of the controlling department
       - firstname, lastname of the manager of the department
       - total number of employee-work assignments
	   [no. of worker-project assignments from works_on] for the project
:)

<results>
  {
    for $proj in doc("../company/project.xml")//project
    let $dep := doc("../company/department.xml")//department[dnumber = $proj/dnum]
    let $mgr := doc("../company/employee.xml")//employee[ssn = $dep/mgrssn]
    let wrk := doc("../company/works_on.xml")//works_on[pno = $proj/pnumber]
    return
    <row>
      <project name="{$proj/pname}"/>
      <department name="{$dep/dname}"/>
      <manager name="{$mgr/fname} {$mgr/minit} {$mgr/lname}"/>
      <work assignments="{count($wrk)}"/>
    </row>
  }
</results>
