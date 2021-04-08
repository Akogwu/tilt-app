import React from 'react';
import '../custom.scss';

const DetailedCardsSection = (props) => {
    return (
        <div className="section-header py-0 pt-8 pt-lg-5">
            <div className="container">
                <div className="row mt-n9 detailed-section">
                    {props.children}
                </div>
            </div>
        </div>
    );
};

export default DetailedCardsSection;
