<?php
/**
 * PluginBaseController
 * 所有的插件都要继承此controller
 * @author xiongchuan <xiongchuan86@gmail.com>
 */
namespace app\common\components;
use yii\base\UnknownPropertyException;
use yii;
use yii\web\Controller;
class PluginBaseController extends Controller
{
	protected $pluginName = "";

    public $layout = '/main';//必须是/main,斜线不能去掉,否则Plugin找不到模板

    public function getUniqueId()
    {
        if('plugin' == $this->module->getUniqueId()){
            //如果是plugin开头的plugin
            $pluginId = '';
            try{
                $pluginId = $this->module->pluginid;
            }catch (UnknownPropertyException $e){
                $array = explode("/",Yii::$app->requestedRoute);
                $pluginId = count($array)>1 ? $array[1] : '';
            }
            if($pluginId)
                return $this->module instanceof Application ? $this->id : $this->module->getUniqueId() . '/' . $pluginId . '/' . $this->id;
        }
        return $this->module instanceof Application ? $this->id : $this->module->getUniqueId() . '/' . $this->id;
    }
	
	public function init()
	{
		parent::init();
		$this->getPluginName();
	}
	
	public function getViewPath()
	{
		return $this->module->getViewPath();
	}
	
	/**
	 * 通过类名获取插件的名字
	 */
	public function getPluginName()
	{
		$className = get_called_class();
		$this->pluginName = str_replace("Controller", "", $className);
	}
}
