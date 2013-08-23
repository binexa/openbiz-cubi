<ul data-role="listview" data-inset="true">
	{foreach item=item from=$widget.menu}
		{if $item->m_ChildNodes|@count > 0}
		<li data-role="list-divider">{$item->objectName}</li>
		{foreach item=subitem from=$item->m_ChildNodes}
			{assign var='current' value='0'}
    	    {foreach item=bc from=$widget.breadcrumb}
    			{if $subitem->m_Id == $bc->m_Id}
    	    		{assign var='current' value='1'}
    			{/if}
    	    {/foreach}
            <li><a href="{if $subitem->m_URL}{$subitem->m_URL}{else}javascript:{/if}">{$subitem->objectName}</a></li>
		{/foreach}	
		{/if}
	{/foreach}
</ul>