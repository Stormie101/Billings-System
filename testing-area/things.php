<?php
for ($i = 1; $i <= $numQuotations; $i++) {
    echo "<hr>";
    echo "<h5><b>PURCHASE ORDER INPUT $i</b></h5>";
    echo "<table>";
    echo "<tr>";
    echo "<td><p style='display:none;'>No</p></td>";
    echo "<td><input type='hidden' name='nom[]' value='$i' required> </input></td>";
    echo "</tr>";
    echo "<td><p>Name</p></td>";
    echo "<td><input type='text' name='title[]' required> </input></td>";
    echo "</tr>";
    echo "<tr>";
    echo "<td><p>Description</p></td>";
    echo "<td><textarea name='desc[]' cols='30' rows='5' required> </textarea></td>";
    echo "</tr>";
    echo "</tr>";
    echo "<td><p>Date</p></td>";
    echo "<td><input type='date' name='PODate[]' required> </input></td>";
    echo "</tr>";
    echo "<tr>";
    echo "<td><p>Quantity</p></td>";
    echo "<td><input type='text' name='quantity[]' id='quantity_$i' value='" . (isset($_POST['quantity'][$i - 1]) ? $_POST['quantity'][$i - 1] : "") . "' oninput='calculateTotal($i)' oninput='calculateTotal($i); updateCalculationTotals()' required></input></td>";    
    echo "</tr>";
    echo "<tr>";
    echo "<td><p>U.Price</p></td>";
    echo "<td><input type='text' name='unit_price[]' id='unit_price_$i' oninput='calculateTotal($i)' oninput='calculateTotal($i); updateCalculationTotals()' required></input></td>";
    echo "</tr>";
    echo "<tr>";
    echo "<td><p>GST</p></td>";
    echo "<td>
        <select name='gst_option[]' id='gst_option_$i' onchange='calculateTotal($i)' oninput='calculateTotal($i); updateCalculationTotals()'>
            <option value='no'>No</option>
            <option value='yes'>Yes</option>
        </select>
        <td><input type='text' name='gst_amount[]' id='gst_amount_$i' readonly></input></td>

         </td>";
    echo "<tr>";
    echo "<td><p style='display:none;'>Discount (%)</p></td>";
    echo "<td><input type='hidden' name='discount_percentage[]' id='discount_percentage_$i' oninput='calculateTotal($i)' oninput='calculateTotal($i); updateCalculationTotals()'></input></td>";
    echo "</tr>";
    echo "<tr>";
    echo "<td><p>Quotation $i Total </p></td>";
    echo "<td><input type='text' name='item_total[]' id='item_total_$i' readonly ></input></td>";
    echo "</tr>";
    echo "</table>";
}
?>