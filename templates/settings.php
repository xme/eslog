<?php if(basename($_SERVER['REQUEST_URI'])=='admin'): ?>
<form id="eslogsettings" method="post" action="#" class="section">
	<h2>Elasticsearch Log</h2>
	<p>
	Send OwnCloud events to an <a href="http://www.elasticsearch.org/">Elasticsearch</a> server.</br>
    
	<p>
		<input type="text" id="eslog_host" name="eslog_host" value="<?php echo $_['eslog_host']; ?>" size="50"/>
		<label for="eslog_host">ElasticSearch server (Use the following format: [fqdn|ip]:port)</label>
	</p>
	<p>
		<select id="eslog_auth" name="eslog_auth">
			<option value="none"<?php if ($_['eslog_auth'] == "none") { echo " selected"; }?>>None</option>
			<option value="basic"<?php if ($_['eslog_auth'] == "basic") { echo " selected"; }?>>Basic</option>
			<option value="digest"<?php if ($_['eslog_auth'] == "digest") { echo " selected"; }?>>Digest</option>
			<option value="ntlm"<?php if ($_['eslog_auth'] == "ntml") { echo " selected"; }?>>NTML</option>
			<option value="any"<?php if ($_['eslog_auth'] == "any") { echo " selected"; }?>>Any</option>
		</select>
		<label for="eslog_auth">Authentication method</label>
	</p>
	<p>
		<input type="text" id="eslog_user" name="eslog_user" value="<?php echo $_['eslog_user']; ?>" size="50"/>
		<label for="eslog_user">ElasticSearch user</label>
	</p>
	<p>
		<input type="text" id="eslog_password" name="eslog_password" value="<?php echo $_['eslog_password']; ?>" size="50"/>
		<label for="eslog_password">ElasticSearch password</label>
	</p>
	<p>
		<input type="text" id="eslog_index" name="eslog_index" value="<?php echo $_['eslog_index']; ?>" size="50"/>
		<label for="eslog_index">ElasticSearch index</label>
	</p>
	<p>
		<input type="text" id="eslog_type" name="eslog_type" value="<?php echo $_['eslog_type']; ?>" size="50"/>
		<label for="eslog_type">ElasticSearch type</label>
	</p>
        <input type="submit" value="Save"/> 
	</p>
</form> 
<?php endif; ?>
