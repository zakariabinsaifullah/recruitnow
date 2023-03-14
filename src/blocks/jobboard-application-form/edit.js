/**
 * WordPress dependencies
 */
import { __ } from '@wordpress/i18n';
import { useBlockProps, InspectorControls } from '@wordpress/block-editor';
import { Card, CardHeader, CardBody, TextControl } from '@wordpress/components';
const { Fragment } = wp.element;

// editor style
import './editor.scss';

export default function Edit({ attributes, setAttributes }) {
	const { btnText, vacancyId, titlePrefix } = attributes;
	return (
		<Fragment>
			<InspectorControls>
				<Card>
					<CardHeader>
						<strong>{__('Form Settings', 'recruitnow')}</strong>
					</CardHeader>
					<CardBody>
						<TextControl
							label={__('Vacancy ID*', 'recruitnow')}
							value={vacancyId}
							onChange={(value) =>
								setAttributes({
									vacancyId: value,
								})
							}
						/>
						<TextControl
							label={__('Apply Button Text', 'recruitnow')}
							value={btnText}
							onChange={(value) =>
								setAttributes({
									btnText: value,
								})
							}
							placeholder={__('Apply', 'recruitnow')}
						/>
						<TextControl
							label={__('Form Title Prefix', 'recruitnow')}
							value={titlePrefix}
							onChange={(value) =>
								setAttributes({
									titlePrefix: value,
								})
							}
							placeholder={__('Apply for', 'recruitnow')}
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
				{!vacancyId && (
					<p className="error">
						<strong>{__('Error: ', 'recruitnow')} </strong>
						{__(
							'Please enter a valid Vacancy ID. It is required to display the form.',
							'recruitnow'
						)}
					</p>
				)}
				<div className="settings-area">
					<Card>
						<CardHeader>
							<strong>{__('Form Settings', 'recruitnow')}</strong>
						</CardHeader>
						<CardBody>
							<TextControl
								label={__('Vacancy ID*', 'recruitnow')}
								value={vacancyId}
								onChange={(value) =>
									setAttributes({
										vacancyId: value,
									})
								}
							/>
							<div className="spacer"></div>
							<TextControl
								label={__('Apply Button Text', 'recruitnow')}
								value={btnText}
								onChange={(value) =>
									setAttributes({
										btnText: value,
									})
								}
								placeholder={__('Apply', 'recruitnow')}
							/>
							<div className="spacer"></div>
							<TextControl
								label={__('Form Title Prefix', 'recruitnow')}
								value={titlePrefix}
								onChange={(value) =>
									setAttributes({
										titlePrefix: value,
									})
								}
								placeholder={__('Apply for', 'recruitnow')}
							/>
						</CardBody>
					</Card>
				</div>
			</div>
		</Fragment>
	);
}
