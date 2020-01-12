<?php


namespace Listener\Service;


use Listener\Model\Message;
use Zend\Validator\InArray;
use Zend\Validator\NotEmpty;
use Zend\Validator\Regex;
use Zend\Validator\StringLength;
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
        if($this->array_keys_diff($this->requiredFields, $data)) {
            return false;
        };
        foreach ($data['destination'] as $key=>$destination){
            if($this->array_keys_diff($this->requiredDestinationFields, $destination)) {
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

    public  function validateMessageFields(Message $message):bool
    {
        return $this->validateTextField($message->getText())
        && $this->validateIdentifierField($message->getIdentifier())
        && $this->validateMessangerField($message->getMessanger());
    }
    protected function validateTextField(string $value):bool
    {
        $validator = new ValidatorChain();

        $validator->attach(new NotEmpty());
        $validator->attach(new StringLength(['min' => 1, 'max' => 4096]));

        $isValid = $validator->isValid($value);

        return $isValid;
    }
    protected function validateIdentifierField(string $value):bool
    {
        $validator = new ValidatorChain();

        $validator->attach(new NotEmpty());
        $validator->attach(new StringLength(['min' => 1, 'max' => 16]));
//        '/^[0-9\-\(\)\/\+\s]*$/'
        $validator->attach(new Regex(['pattern' => '/^[+]?[0-9]{0,4}[(\s]*[0-9]{1,4}[)\s]?[\d\-\s]*$/']));

        $isValid = $validator->isValid($value);
        return $isValid;
    }
    protected function validateMessangerField(string $value):bool
    {
        $validator = new ValidatorChain();

        $validator->attach(new NotEmpty());
        $validator->attach(new InArray(['haystack' => ['viber','telegram']]));

        $isValid = $validator->isValid(strtolower($value));

        return $isValid;
    }

    /**
     * @param array $keys
     * @param array $array
     *
     * @return array
     */
    protected function array_keys_diff(array $keys,array $array):array
    {
        return array_diff_key(array_flip($keys), $array);
    }
}
