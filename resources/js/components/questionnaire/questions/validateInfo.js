export default function validateInfo(values){
    const errors = {};

    if (!values.question.trim())
        errors.question = 'Question is required';

    return errors;
}
