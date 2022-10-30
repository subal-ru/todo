//common系は個別に読み込む
import { setModalCloseEvent } from './parts/common.js';
setModalCloseEvent();

// header関連js読み込み
import { headerSettingFunc } from './parts/header.js';
headerSettingFunc();

// main部js読み込み
import { mainSettingFunc } from './home/main.js';
mainSettingFunc();

// group関連js読み込み
import { groupSettingFunc } from './home/group.js';
groupSettingFunc();