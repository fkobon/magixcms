{if $config_catalog eq 1}
<script type="text/javascript">
    var catalog_tinymce_plugin = ",mc_catalog";
    var catalog_tinymce_button = ",mc_catalog";
</script>
    {else}
<script type="text/javascript">
    var catalog_tinymce_plugin = "";
    var catalog_tinymce_button = "";
</script>
{/if}
{if $editor eq 'imagemanager'}
<script type="text/javascript">
    var manager_tinymce_plugin = ",imagemanager";
    var manager_tinymce_button = ",insertimage";
    var tinymce_call_back = "";
</script>
    {elseif $editor eq 'openFilemanager'}
<script type="text/javascript">
    var manager_tinymce_plugin = "";
    var manager_tinymce_button = "";
    var tinymce_call_back = "filemanager";
</script>
{/if}
{if $tinymce_filemanager eq 1}
<script type="text/javascript">
    var filemanager_tinymce_plugin = ",filemanager";
    var filemanager_tinymce_button = ",insertfile";
</script>
    {else}
<script type="text/javascript">
    var filemanager_tinymce_plugin = "";
    var filemanager_tinymce_button = "";
</script>
{/if}
<script type="text/javascript">
    content_css = "{$content_css}";
</script>