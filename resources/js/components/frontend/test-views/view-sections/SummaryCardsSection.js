import React from 'react';
import './custom.scss';

const SummaryCardsSection = (props) => {
    return (
        <div className="section-header py-0 pt-8 pt-lg-5">
            <div className="container">
                <div className="row mt-n9 summary-grid">
                    {props.children}
                </div>
            </div>
        </div>
    );
};

export default SummaryCardsSection;
