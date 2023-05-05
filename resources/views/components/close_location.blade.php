<label for="close_icon">Chose an icon for this location: </label>
<select name="close_location[close_icon]" id="close_icon" class="w-28 h-auto material-symbols-rounded fs-48">
    <option value="local_hospital">local_hospital</option>
    <option  value="shopping_cart">shopping_cart</option>
    <option value="account_balance">account_balance</option>
    <option value="hotel">hotel</option>
    <option value="account_balance">other_houses</option>
</select>
<x-input :type="'text'" :name="'close_name'" :placeholder="'Place name'"/>
<x-input :type="'text'" :name="'close_location'" :placeholder="'Place location'"/>
<x-input :type="'text'" :name="'close_phone'" :placeholder="'Place phone'"/>
<button class="bg-green-600 text-white flex justify-center items-center rounded-lg p-3 mb-12" id="add" onclick=""><span class="material-symbols-rounded h-full">save</span>Save</button>