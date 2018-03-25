(: Output the firstname and lastname of each pair of employees who work for the same project. There should not be any duplicate reversed pair and no employee be paired with the same employee :)
<results>
  {
    for $A in doc("../company/works_on.xml")//works_on,
        $B in doc("../company/works_on.xml")//works_on,
        $emp1 in doc("../company/employee.xml")//employee,
        $emp2 in doc("../company/employee.xml")//employee
    where $A/pno = $B/pno and $A/essn < $B/essn and $emp1/ssn = $A/essn and $emp2/ssn = $B/essn
    order by $A/pno
    return
    <row>
       <wkon pno="{$A/pno}"/>
       <emp1 fname="{$emp1/fname}" lname="{$emp1/lname}"/>
       <emp2 fname="{$emp2/fname}" lname="{$emp2/lname}"/>
    </row>
  }
</results>
