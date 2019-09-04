<?php
namespace Drupal\xstats\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

class XstatsSettingsForm extends ConfigFormBase {

    const SETTINGS = 'xstats.settings';

    public function getFormId()
    {
        return 'xstats_admin_settings';
    }

    protected function getEditableConfigNames()
    {
        return [
            static::SETTINGS,
        ];
    }

    public function buildForm(array $form, FormStateInterface $form_state)
    {
        $config = $this->config(static::SETTINGS);

        $form['xstats_status'] = [
            '#type' => 'fieldset',
            '#title' => t('Status'),
        ];
        $form['xstats_status']['xstats_active'] = [
            '#type' => 'checkbox',
            '#title' => t('Activate Xstats'),
            '#default_value' => $config->get('xstats_active') ? $config->get('xstats_active') : false,
        ];
        $form['xstats_connection'] = [
            '#type' => 'fieldset',
            '#title' => t('Connection Info')
        ];
        $form['xstats_connection']['xstats_scheme'] = [
            '#type' => 'select',
            '#title' => t('Scheme'),
            '#default_value' => $config->get('xstats_scheme') ? $config->get('xstats_scheme') : 'tcp',
            '#options' => [
                'tcp' => 'tcp',
                'unix' => 'unix',
                'tls' => 'tls',
            ]
        ];
        $form['xstats_connection']['xstats_redis_host'] = [
            '#type' => 'textfield',
            '#title' => $this->t('Redis Host'),
            '#default_value' => $config->get('xstats_redis_host') ? $config->get('xstats_redis_host') : 'localhost',
        ];

        $form['xstats_connection']['xstats_redis_port'] = [
            '#type' => 'textfield',
            '#title' => $this->t('Port'),
            '#default_value' => $config->get('xstats_redis_port') ? $config->get('xstats_redis_port') : '6379',
        ];

        return parent::buildForm($form, $form_state);
    }


	public function submitForm(array &$form, FormStateInterface $form_state) {
		$this->configFactory->getEditable(static::SETTINGS)
			->set('xstats_active', $form_state->getValue('xstats_active'))
            ->set('xstats_scheme', $form_state->getValue('xstats_scheme'))
			->set('xstats_redis_host', $form_state->getValue('xstats_redis_host'))
			->set('xstats_redis_port', $form_state->getValue('xstats_redis_port'))
			->save();


		parent::submitForm($form, $form_state);
	}
}
