<?php
  header('Content-Type: application/json');

  require_once 'upm.php';

  if( !isset( $_POST["fct_name"] ) ) {
    echo json_encode( array('success' => false, 'error' => "no fct_name set") );
    return false;
  }
  if( !isset( $_POST["fct_data"] ) ) {
    echo json_encode( array('success' => false, 'error' => "no fct_data set") );
    return false;
  }

  $fct_name = $_POST["fct_name"];
  $fct_data = $_POST["fct_data"];
  try {  
  switch( $fct_name ) {
    case "get_folders":
      UPM::getFolders($folders);
      echo json_encode( array('success' => true, 'folders' => $folders) );
      break;
    case "get_servers":
      UPM::getServers($servers);
      echo json_encode( array('success' => true, 'servers' => $servers) );
      break;
    case "add_server":
      $server = $fct_data["server"];
      UPM::addServer($server, $server);
 			echo json_encode( array('success' => true) );
			break;
		case "mass_import":
      $import_data = $fct_data["import_data"];
      UPM::massImport($import_data);
      echo json_encode( array('success' => true, 'message' => "Finished mass import") );
      break;
    case "add_folder":
      $folder = $fct_data["folder"];    
			UPM::addFolder($folder);
      echo json_encode( array('success' => true) );
      break;
    case "delete_server":
      $server_id = $fct_data["server_id"];
      UPM::deleteServer( $server_id );
      echo json_encode( array('success' => true, 'message' => "Successfully delete host")  );
      break;
    case "move_server" :
      $server_id = $fct_data["server_id"];
      $folder_id = $fct_data["folder_id"];
      UPM::moveServer($server_id, $folder_id);
      echo json_encode( array('success' => true, 'message' => "Successfully moved host")  );
      break;
    case "delete_folder":
      $folder_id = $fct_data["folder_id"];
      UPM::deleteFolder( $folder_id );
      echo json_encode( array('success' => true, 'message' => "Successfully deleted folder.")  );
      break;
    case "move_folder":
      $folder_id = $fct_data["folder_id"];
      $parent_id = $fct_data["parent_id"];
      UPM::moveFolder($folder_id, $parent_id);
      echo json_encode( array('success' => true, 'message' => "Successfully moved folder")  );
      break;
    case "get_server_info":
      $server_id = $fct_data["server_id"];
      //$initial_run = $fct_data["initial_run"];
      //$update_root_folder = $fct_data["update_root_folder"];
      UPM::getServerInfo($server_id, $server);
      echo json_encode( array('success' => true, "server_id" => $server_id, 'server' => $server) );
      break;
    case "get_folder_info":
      $folder_id = $fct_data["folder_id"];

      UPM::getFolderInfo($folder_id, $folder);
      echo json_encode( array('success' => true, "folder_id" => $folder_id, 'folder' => $folder) );
      break;
    case "update_server_config":
      $server_id = $fct_data["server_id"];
      $name = $fct_data["name"];
      $hostname = $fct_data["hostname"];
      $ssh_private_key = $fct_data["ssh_private_key"];
      $ssh_port = $fct_data["ssh_port"];
      $ssh_username = $fct_data["ssh_username"];
      $user_distribution = $fct_data["user_distribution"];
      UPM::setServerConfig($server_id, $name, $hostname, $user_distribution,$ssh_private_key, $ssh_port, $ssh_username, $server);
      echo json_encode( array('success' => true, 'server_id' => $server_id, 'server' => $server, 'message' => 'Successfully updated host config'));
      break;

    case "update_folder_config":
      $folder_id = $fct_data["folder_id"];
      $name = $fct_data["name"];
      $icon = $fct_data["icon"];
      $ssh_private_key = $fct_data["ssh_private_key"];
      $ssh_port = $fct_data["ssh_port"];
      $ssh_username = $fct_data["ssh_username"];
      UPM::setFolderConfig($folder_id, $name, $icon,$ssh_private_key, $ssh_port, $ssh_username);
      echo json_encode( array('success' => true, 'folder_id' => $folder_id, 'message' => 'Successfully updated folder config'));
      break;
      //ToDo
    case "get_global_config": 
      UPM::getGlobalConfig( $config );
      echo json_encode( array('success' => true, 'config' => $config) );
      break;
    case "get_distribution_config_1": //TODO: Rename
      $config_id = $fct_data["config_id"];
      UPM::getDistributionConfig($config_id, $config);
      echo json_encode( array('success' => true, 'config' => $config) );      
      break;
    case "get_distribution_config":
      UPM::getDistributionOverview($configs);
      echo json_encode( array('success' => true, 'config' => $configs) );
      break;
    case "get_eol_config":
      UPM::getEolOverview($configs);
      echo json_encode( array('success' => true, 'config' => $configs) );
      break;
    case "get_eol_config_1":
      $eol_id = $fct_data["eol_id"];
      UPM::getEolConfig($eol_id, $config);
      echo json_encode( array('success' => true, 'config' => $config) );
      break;
    case "server_get_update_output":
      $server_update_output_id = $fct_data["server_update_output_id"];
      UPM::getServerUpdateOutput($server_update_output_id, $server_id, $output);
      echo json_encode( array('success' => true, 'server_id' => $server_id, 'output' => $output) );
      break;
    case "add_package_important":
      $server_id = $fct_data['server_id'];
      $package = $fct_data['pack'];
      $comment = $fct_data['comment'];

      UPM::addImportantUpdate($server_id, $package, $comment, $server);
      echo json_encode( array('success' => true, 'server_id' => $server_id, 'server' => $server ) );
      break;
    case "edit_package_important":
      $iu_id = $fct_data['iu_id'];
      $server_id = $fct_data['server_id'];
      $package = $fct_data['pack'];
      $comment = $fct_data['comment'];

      UPM::updateImportantUpdate($server_id, $iu_id, $package, $comment, $server);
      echo json_encode( array('success' => true, 'server_id' => $server_id, 'server' => $server ) );
      break;
    case "delete_package_important":
      $iu_id = $fct_data['iu_id'];
      $server_id = $fct_data['server_id'];

      UPM::deleteImportantUpdate($server_id, $iu_id, $server);
      echo json_encode( array('success' => true, 'server_id' => $server_id, 'server' => $server ) );
      break;
    case "insert_eol_config":
      $distri_name = $fct_data["distri_name"];
      $eol = $fct_data["eol"];

      UPM::addEolConfig($distri_name, $eol);
      echo json_encode( array('success' => true, 'message' => "Successfully added eol config") );
      break;
    case "update_eol_config":
      $eol_id = $fct_data["eol_id"];
      $distri_name = $fct_data["distri_name"];
      $eol = $fct_data["eol"];

      UPM::updateEolConfig($eol_id, $distri_name, $eol);
      echo json_encode( array('success' => true, 'message' => "Successfully updated eol config") );
      break;
    case "delete_eol_config":
      $eol_id = $fct_data["eol_id"];

      UPM::deleteEolConfig($eol_id);
      echo json_encode( array('success' => true, 'message' => "Successfully deleted eol config") );
      break;
    case "insert_distribution_config":
      $config_name = $fct_data["config_name"];
      $distri_name = $fct_data["distri_name"];
      $distri_version = $fct_data["distri_version"];
      $uptime = $fct_data["uptime"];
      $restart = $fct_data["restart"];
      $update_list = $fct_data["update_list"];
      $package_info = $fct_data["package_info"];
      $package_changelog = $fct_data["package_changelog"];
      $system_update = $fct_data["system_update"];
      $package_update = $fct_data["package_update"];
      $shedule_reboot_add = $fct_data["shedule_reboot_add"];
      $shedule_reboot_get = $fct_data["shedule_reboot_get"];
      $shedule_reboot_del = $fct_data["shedule_reboot_del"];

      UPM::addDistributionConfig($config_name, $distri_name, $distri_version,
        $uptime, $restart, $update_list, $package_info, $package_changelog,
        $system_update, $package_update, $shedule_reboot_add, $shedule_reboot_get, $shedule_reboot_del);
        echo json_encode( array('success' => true, 'message' => "Successfully added distribution config") );
      break;
    case "update_distribution_config":
      $config_id = $fct_data["config_id"];
      $config_name = $fct_data["config_name"];
      $distri_name = $fct_data["distri_name"];
      $distri_version = $fct_data["distri_version"];
      $uptime = $fct_data["uptime"];
      $restart = $fct_data["restart"];
      $update_list = $fct_data["update_list"];
      $package_info = $fct_data["package_info"];
      $package_changelog = $fct_data["package_changelog"];
      $system_update = $fct_data["system_update"];
      $package_update = $fct_data["package_update"];
      $shedule_reboot_add = $fct_data["shedule_reboot_add"];
      $shedule_reboot_get = $fct_data["shedule_reboot_get"];
      $shedule_reboot_del = $fct_data["shedule_reboot_del"];

      UPM::updateDistributionConfig($config_id, $config_name, $distri_name, $distri_version,
        $uptime, $restart, $update_list, $package_info, $package_changelog,
        $system_update, $package_update, $shedule_reboot_add, $shedule_reboot_get, $shedule_reboot_del);
      echo json_encode( array('success' => true, 'message' => "Successfully updated distribution config") );
      break;
    case "delete_distribution_config":
      $config_id = $fct_data["config_id"];

      UPM::deleteDistributionConfig($config_id);
      echo json_encode( array('success' => true, 'message' => "Successfully deleted distribution config") );
      break;
    case "update_global_config":
      $default_ssh_private_key = $fct_data["default_ssh_private_key"];
      $default_ssh_port = $fct_data["default_ssh_port"];
      $default_ssh_username = $fct_data["default_ssh_username"];
      $default_distribution_command = $fct_data["default_distribution_command"];
      $default_distribution_version_command = $fct_data["default_distribution_version_command"];

      UPM::updateGlobalConfig($default_ssh_private_key, 
        $default_ssh_port, $default_ssh_username, $default_distribution_command, $default_distribution_version_command);
      echo json_encode( array('success' => true, 'message' => 'Successfully updated global config'));
      break;
    case "inventory_server":
    case "inventory_server_from_list":
      $server_id = $fct_data["server_id"];

      UPM::inventoryServer($server_id, $server, $error);
      echo json_encode( array('success' => true, 'server_id' => $server_id, 'server' => $server));
      break;
    case "get_package_changelog":
      $update_id = $fct_data["update_id"];

      UPM::getPackageChangelog($update_id, $changelog);
      echo json_encode( array('success' => true, 'changelog' => $changelog) );
      break;
    case "get_package_info":
      $update_id = $fct_data["update_id"];
      
      UPM::getPackageInfo($update_id, $info);
      echo json_encode( array('success' => true, 'info' => $info) );      
      break;
    case "update_package":
      $update_id = $fct_data["update_id"];
      $server_id = $fct_data["server_id"];
      UPM::updatePackage($update_id, $output, $server);
      echo json_encode( array('success' => true, 'server_output' => $output, 'server_id' => $server_id, 'server' => $server) );
      break;
    case "update_server":
    case "update_server_from_list":
      $server_id = $fct_data['server_id'];

      UPM::updateServer($server_id, $output, $server);
      echo json_encode( array('success' => true, 'server_output' => $output, 'server_id' => $server_id, 'server' => $server) );
      break;
    case "shedule_reboot_add":
    case "shedule_reboot_add_list":
      $server_id = $fct_data['server_id'];
      $timestamp = $fct_data['timestamp'];

      UPM::addSheduleReboot($server_id, $timestamp, $sheduled_restart, $server);
      echo json_encode( array('success' => true, 'server_id' => $server_id, 'reboot' => $sheduled_restart, 'server' => $server) );
      break;
    case "shedule_reboot_del":
    case "shedule_reboot_del_list":
      $server_id = $fct_data['server_id'];

      UPM::delSheduleReboot($server_id, $server);
      echo json_encode( array('success' => true, 'server_id' => $server_id, 'server' => $server) );
      break;
    default:
      echo json_encode( array('success' => false, 'error' => "unknown fct_name " . $fct_name) );
      return false;
      break;
  }
  } catch(Exception $ex) {
    echo json_encode( array('sucess' => false, 'message' => $ex->getMessage()));
  }

  return true;
