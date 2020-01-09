<?php


namespace Listener\Service;


use Zend\Validator\ValidatorChain;

class ValidatorService implements ValidatorServiceInterface
{
    protected $requiredFields = ['text','destination'];
    protected $requiredDestinationFields = ['identifier','messanger'];
    public function validateRequestData(array $data): bool
    {
        if (empty($data)) {
            return false;
        }
        if($this->array_keys_diff($this->requiredFields,$data)){
            return false;
        };
        if(!is_array($data['destination'])){
            $data['destination'] = [$data['destination']];
        }
        foreach ($data['destination'] as $key=>$destination){
            if($this->array_keys_diff($this->requiredDestinationFields,$destination)){
                //idea: split validation levels
                //unset($data['destination'][$key]);
                return false;
            }
        }
//        if(empty($data['destination'])){
//            return false;
//        }
        return true;
    }

    protected function validateField(string $value)
    {
        $validator = new ValidatorChain();

        $validator->attachByName('NotEmpty');
        $validator->attachByName('StringLength', ['min' => 1, 'max' => 16]);
        $validator->attachByName('Date', ['format' => 'Y-m-d']);

        $isValid = $validator->isValid($value);

        return $isValid;
    }

    protected function array_keys_diff($keys,$array){
        return array_diff_key(array_flip($keys),$array);
    }
}