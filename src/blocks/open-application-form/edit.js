/**
 * WordPress dependencies
 */
import { __ } from '@wordpress/i18n';
import { useBlockProps } from '@wordpress/block-editor';
import { Card, CardHeader, CardBody } from '@wordpress/components';
const { Fragment } = wp.element;

// editor style
import './editor.scss';

export default function Edit() {
	return (
		<Fragment>
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
							<p className="default-value-note">
								<strong>{__('Note: ')}</strong>
								{__(
									'No special settings are required for this block. It will automatically display the Open Enrollment Form.',
									'recruitnow'
								)}
							</p>
						</CardBody>
					</Card>
				</div>
			</div>
		</Fragment>
	);
}
