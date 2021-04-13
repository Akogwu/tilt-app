import React from 'react';

const PageButtonSubmit = (props) => {
    return (
        <a
            onClick={(event) => props.onClick(event)}
            href={props.link}
            className={`w-full inline-flex justify-center rounded-full border border-transparent shadow-sm px-4 py-2 bg-${props.color}-600 text-base font-medium text-white hover:bg-${props.color}-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-${props.color}-500 sm:ml-3 sm:w-auto sm:text-sm animate-up-4 mr-3`}>
            <span className="btn-inner-text text-white">
                {props.text}
                <i className={`fas ${props.icon} ml-3`}> </i>
            </span>
        </a>
    );
};

export default PageButtonSubmit;