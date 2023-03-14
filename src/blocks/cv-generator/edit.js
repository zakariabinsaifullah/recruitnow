/**
 * WordPress dependencies
 */
import { __ } from '@wordpress/i18n';
import { useBlockProps, InspectorControls } from '@wordpress/block-editor';
import {
	Card,
	CardHeader,
	CardBody,
	ToggleControl,
} from '@wordpress/components';
const { Fragment } = wp.element;

// editor style
import './editor.scss';

export default function Edit({ attributes, setAttributes }) {
	const { isCandidateEnrollment } = attributes;
	return (
		<Fragment>
			<InspectorControls>
				<Card>
					<CardHeader>
						<strong>{__('Form Settings', 'recruitnow')}</strong>
					</CardHeader>
					<CardBody>
						<ToggleControl
							label={__(
								'Automatically enroll candidate',
								'recruitnow'
							)}
							checked={isCandidateEnrollment}
							onChange={() =>
								setAttributes({
									isCandidateEnrollment:
										!isCandidateEnrollment,
								})
							}
						/>
					</CardBody>
				</Card>
			</InspectorControls>
			<div {...useBlockProps()}>
				<p className="note">
					<strong>{__('Note: ', 'recruitnow')} </strong>
					{__(
						'Preview is not available for this block. Please use the frontend to preview.',
						'recruitnow'
					)}
				</p>
				<div className="settings-area">
					<Card>
						<CardHeader>
							<strong>{__('Form Settings', 'recruitnow')}</strong>
						</CardHeader>
						<CardBody>
							<ToggleControl
								label={__(
									'Automatically enroll candidate',
									'recruitnow'
								)}
								checked={isCandidateEnrollment}
								onChange={() =>
									setAttributes({
										isCandidateEnrollment:
											!isCandidateEnrollment,
									})
								}
							/>
						</CardBody>
					</Card>
				</div>
			</div>
		</Fragment>
	);
}
