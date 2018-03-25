(:
    For each department, output
       - name of the department
       - number of projects controlled by this project
       - total number of hours worked by all employees for all these projects
:)
<results>
  {
    for $dep  in doc("../company/department.xml")//department
    let $proj := doc("../company/project.xml")//project[dnum = $dep/dnumber]
    return
    <row>
       <department name="{$dep/dname}"/>
       <project count="{count($proj)}"/> 
       {
         let $wrk := doc("../company/works_on.xml")//works_on[pno = $proj/pnumber]
         return
         <work-hours hours="{sum($wrk/hours)}"/>
       }
    </row>
  }
</results>
