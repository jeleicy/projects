<table width="60%" border="0" cellspacing="2" cellpadding="10" class="tablas_int" align="center">
    <tr>
        <td align="right" colspan="2">Elecciones <img style="cursor:pointer" src="images/cancel.gif" onclick="closebox('eleccion')" />
            <img src="images/vineta.gif" onclick="closebox_data('eleccion')" />
        </td>
    </tr>
    <tr class="fondo2">
        <td align="right">Nombre:<span class="error">(*)</span></td>
        <td><input type="text" name="nombres_eleccion" value="" /></td>
    </tr>
    <tr class="fondo1">
        <td align="right">Tipo:<span class="error">(*)</span></td>
        <td><select name="tipo_eleccion">
                <option value="P">PRESIDENCIALES</option>
            </select>	</td>
    </tr>
    <tr class="fondo2">
        <td align="right">Fecha:<span class="error">(*)</span></td>
        <td>
            <input name="fechas_eleccion" type='text' readonly  id='fechas_eleccion' class="input_peq" tabindex='130' value="" />
            <img src='images/calendario.gif' title='Click Here' alt='Click Here' onclick="scwShow(scwID('fechas_eleccion'),this,3);" />
            <img src='images/cancel.gif' title='Click Here' alt='Click Here' onclick="document.forms[0].fechaelec.value='';" />
            <span class="error">(Borrar Fecha)</span>
        </td>
    </tr>
</table>
<br /><br />
<div align="center">
    <input class="btn btn-primary" type="button" name="Buscar Eleccion" value="Buscar Eleccion" onclick="ajax_buscar_elecciones()" />
</div>
<div id="resultado_eleccion"></div>