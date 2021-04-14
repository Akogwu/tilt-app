import React from 'react';

const PageButtonIconLeft = (props) => {
    return (
        <a
            onClick={(event) => props.onClick(event)}
            href={props.link}
            className={`btn btn-pill btn-lg btn-${props.color} animate-up-4 mr-3`}>
            <span className="btn-inner-text text-white">
                <i className={`fas ${props.icon} mr-3`}> </i>
                {props.text}
            </span>
        </a>
    );
};

export default PageButtonIconLeft;
